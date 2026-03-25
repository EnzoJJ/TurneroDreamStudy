<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Turns;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\BlockedDay;
use App\Models\Barber;

class AdminTurnController extends Controller
{
    public function index()
    {
        \Carbon\Carbon::setLocale('es');
        $today = \Carbon\Carbon::today();

        $turns = Turns::with('barber')
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('start_time', 'asc')
            ->get()
            ->groupBy([
                'barber.name', 
                function ($item) use ($today) {
                    $date = \Carbon\Carbon::parse($item->start_time)->startOfDay();
                    $diff = $today->diffInDays($date, false);

                    if ($diff == 0) {
                        return 'Hoy';
                    } elseif ($diff == 1) {
                        return 'Mañana';
                    } else {
                        return $date->translatedFormat('l d \d\e F');
                    }
                }
            ]);

        return view('admin.turns.index', compact('turns'));
    }

    public function destroy(Turns $turn)
    {
        $turn->delete();
        return back()->with('success', 'Turno finalizado correctamente.');
    }

    public function editSettings() 
    {
        // 1. Obtenemos la configuración (o la creamos si no existe)
        $settings = Setting::firstOrCreate(
            ['id' => 1],
            ['opening_time' => '10:00', 'closing_time' => '19:00', 'slot_duration' => 40]
        );

        // 2. IMPORTANTE: Traer todos los barberos para el selector del formulario
        $barbers = \App\Models\Barber::all(); 

        // 3. Traer los días bloqueados con su relación de barbero
        $blockedDays = \App\Models\BlockedDay::with('barber')
            ->orderBy('date', 'asc')
            ->where('date', '>=', now()->toDateString())
            ->get();
        
        // 4. Pasar TODO a la vista
        return view('admin.settings.edit', compact('settings', 'blockedDays', 'barbers'));
    }
    public function updateSettings(Request $request)
    {
        $request->validate([
            'opening_time' => 'required',
            'closing_time' => 'required',
            'slot_duration' => 'required|integer|min:10|max:120',
        ]);

        $settings = Setting::first();
        $settings->update($request->all());

        return back()->with('success', 'Configuración actualizada correctamente.');
    }

    public function storeBlockedDay(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'barber_id' => 'nullable|exists:barbers,id', // Validamos que el barbero exista si se envía uno
            'reason' => 'nullable|string|max:255',
        ]);

        // Importante: Si el select llega vacío, Laravel lo guardará como null automáticamente
        \App\Models\BlockedDay::create($validated);

        return back()->with('success', 'Día bloqueado correctamente.');
    }
    public function destroyBlockedDay(BlockedDay $blockedDay) {
        $blockedDay->delete();
        return back()->with('success', 'Día habilitado nuevamente.');
    }
}