<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use App\Models\ZoneEvent;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    // Metodo que recupera toda la informarción para que se puedan colocar alertas en todas
    public function index()
    {
        $zones = Zone::all();
        $alerts = ZoneEvent::orderBy('created_at', 'desc')->get(); // Recupera todos los eventos en caso de haberlos y los ordena por fecha de creación


        return view('alerts.alerts', compact('zones', 'alerts'));
    }

    // Metodo que se encarga de insertar y las nuesvas alertas
    public function store(Request $request)
    {   // required implica que los campos son obligatorios
        $request->validate([
            'zone_type' => 'required|string',
            'title' => 'required|string|max:100',
            'message' => 'required|string',
            'level' => 'required|in:aviso,alerta,peligro',
        ]);
        // Crea los eventos de forma segura
        ZoneEvent::create([
            'zone_type' => $request->zone_type,
            'title' => $request->title,
            'message' => $request->message,
            'level' => $request->level,
            'active' => true
        ]);
        // redirige al usuario y le avisa de que el evento está creado
        return redirect()->back()->with('success', 'Alerta publicada en el mapa correctamente.');
    }
    // Metodo que destruye los eventos ya creados
    public function destroy($id)
    {
        $alert = ZoneEvent::findOrFail($id); // Busca por id si no encuentra da error sin romper la app
        $alert->delete();

        return redirect()->back()->with('success', 'Alerta eliminada del sistema.');
    }
}
