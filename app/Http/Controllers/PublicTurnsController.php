<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turns;
use App\Models\Barber;
use Illuminate\Support\Str;

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

        //Espacio para el envio de email

        return back()->with('sucess', 'Casi listo! Revisa tu email para confirmar el turno');
    }
}
