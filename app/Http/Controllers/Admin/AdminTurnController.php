<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Turns;
use Illuminate\Http\Request;
use App\Models\Setting;

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
        // Obtenemos la primera configuración o creamos una por defecto si no existe
        $settings = Setting::first() ?? Setting::create([
            'opening_time' => '10:00',
            'closing_time' => '19:30',
            'slot_duration' => 40
        ]);

        return view('admin.settings.edit', compact('settings'));
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
}