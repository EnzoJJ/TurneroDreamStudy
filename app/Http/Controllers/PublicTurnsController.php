<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turns;
use App\Models\Barber;
use Illuminate\Support\Str;
use App\Mail\ConfirmTurnMail;
use Illuminate\Support\Facades\Mail;

class PublicTurnsController extends Controller
{
    public function create(){
        $barbers=Barber::all();
        return view('public.turns.create', compact('barbers'));
    }

    public function store(Request $request){
        $request->validate([
            'barber_id' => 'required|exists:barbers,id',
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email',
            'client_phone' => 'required',
            'start_time' => 'required|date|after:now',
        ]);

        $turn=Turns::create([
            'barber_id'=> $request->barber_id,
            'client_name' => $request->client_name,
            'client_email' => $request->client_email,
            'client_phone' => $request-> client_phone,
            'start_time' => $request->start_time,
            'status' => 'pending',
            'token' => Str::uuid(),
        ]);

        Mail::to($turn->client_email)->send(new ConfirmTurnMail($turn));

        return back()->with('sucess', 'Casi listo! Revisa tu email para confirmar el turno');
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
}
