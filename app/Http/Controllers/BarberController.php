<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barber;

class BarberController extends Controller
{
    public function index()
    {
        $barbers=Barber::all();
        return view('barbers.index', compact('barbers'));
    }

    public function create()
    {
        return view('barbers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
        ]);
        Barber::create($request->all());
        return redirect()->route('admin.barbers.index')->with('sucess', 'Peluquero creado con exito');
    }
    public function edit(Barber $barber)
    {
        return view('barbers.edit', compact('barber'));
    }
    public function update(Request $request, Barber $barber)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $barber->update($request->all());

        return redirect()->route('admin.barbers.index')
                         ->with('success', 'Barbero actualizado correctamente.');
    }

    public function destroy(Barber $barber)
    {
        // Opcional: Podrías verificar si tiene turnos antes de borrar
        $barber->delete();

        return redirect()->route('admin.barbers.index')
                         ->with('success', 'Barbero eliminado del staff.');
    }
}
