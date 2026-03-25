<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turns;
use App\Models\Barber;
use App\Models\Setting;
use Illuminate\Support\Str;
use App\Mail\ConfirmTurnMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\BlockedDay;


class PublicTurnsController extends Controller
{
    public function create(){
        $barbers=Barber::all();
        return view('public.turns.create', compact('barbers'));
    }

    public function store(Request $request)
    {
        $config = Setting::first() ?? (object)[
            'opening_time' => '10:00',
            'closing_time' => '19:30',
            'slot_duration' => 40
        ];
        $opening = $config->opening_time;
        $closing = $config->closing_time;
        $duration = $config->slot_duration;

        $request->validate([
            'barber_id'    => 'required|exists:barbers,id',
            'client_name'  => 'required|string|max:255',
            'client_email' => 'required|email',
            'client_phone' => 'required',
            'start_time'   => 'required|date|after:now',
        ]);

        $dateTime = Carbon::parse($request->start_time);
        $time = $dateTime->format('H:i');

        if ($time < $opening || $time > $closing) {
            return back()->withErrors(['start_time' => "Atendemos de $opening a $closing."])->withInput();
        }

        $startTimeBase = Carbon::parse($dateTime->format('Y-m-d') . ' ' . $opening);
        $diffInMinutes = $startTimeBase->diffInMinutes($dateTime);

        if ($diffInMinutes % $duration !== 0) {
            return back()->withErrors(['start_time' => "Los turnos son cada $duration minutos."])->withInput();
        }

        // --- CAPA 3: Evitar Superposición (Mismo barbero, misma hora) ---
        // Buscamos si ya existe un turno CONFIRMADO o PENDIENTE para ese barbero a esa hora
        $alreadyTaken = Turns::where('barber_id', $request->barber_id)
                            ->where('start_time', $dateTime)
                            ->whereIn('status', ['pending', 'confirmed'])
                            ->exists();

        if ($alreadyTaken) {
            return back()->withErrors(['start_time' => 'Este peluquero ya tiene un turno asignado para ese horario.'])->withInput();
        }

        // 2. Si pasó todas las pruebas, guardamos
        $turn = Turns::create([
            'barber_id'    => $request->barber_id,
            'client_name'  => $request->client_name,
            'client_email' => $request->client_email,
            'client_phone' => $request->client_phone,
            'start_time'   => $dateTime,
            'status'       => 'pending',
            'token'        => Str::uuid(),
        ]);

        // 3. Envío de Mail
        Mail::to($turn->client_email)->send(new ConfirmTurnMail($turn));

        return back()->with('success', '¡Casi listo! Revisa tu email para confirmar el turno.');
    }

    public function confirm($token)
    {
        $turn = Turns::where('token', $token)->first();

        if (!$turn) {
            return "No encontré el turno con el token: " . $token;
        }

        $turn->status = 'confirmed';
        $turn->save();

        return view('public.turns.confirmed_success', compact('turn'));
    }
    public function getAvailableTimes(Request $request)
    {
        // Usamos una sola forma de obtener los datos y nos aseguramos que sean strings/integers limpios
        $date = $request->input('date');
        $barberId = $request->input('barber_id');

        // 1. Verificamos bloqueos (Local cerrado o Barbero de franco)
        // Buscamos si existe algun bloqueo que sea: (Misma fecha Y (ID Barbero O ID es NULL))
        $isBlocked = \App\Models\BlockedDay::where('date', $date)
            ->where(function ($query) use ($barberId) {
                $query->whereNull('barber_id')
                    ->orWhere('barber_id', $barberId);
            })
            ->exists();

        if ($isBlocked) {
            return response()->json([]); // Retornamos vacio de inmediato
        }

        // 2. Configuración de horarios
        $config = Setting::first() ?? (object)[
            'opening_time' => '10:00',
            'closing_time' => '19:30',
            'slot_duration' => 40
        ];

        // 3. Traer turnos ocupados (Filtrando estrictamente por barbero e ID)
        $occupiedTimes = Turns::where('barber_id', $barberId)
            ->whereDate('start_time', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get() // Traemos la colección
            ->map(function($turn) {
                return \Carbon\Carbon::parse($turn->start_time)->format('H:i');
            })
            ->toArray();

        // 4. Generar la lista de turnos posibles
        $startTime = \Carbon\Carbon::parse($date . ' ' . $config->opening_time);
        $endTime = \Carbon\Carbon::parse($date . ' ' . $config->closing_time);
        $duration = (int) $config->slot_duration;

        $slots = [];

        while ($startTime < $endTime) { // Cambié <= por < para evitar turnos que empiecen justo al cierre
            $currentTime = $startTime->format('H:i');
            
            $slots[] = [
                'time' => $currentTime,
                'is_available' => !in_array($currentTime, $occupiedTimes)
            ];

            $startTime->addMinutes($duration);
        }

        return response()->json($slots);
    }
}
