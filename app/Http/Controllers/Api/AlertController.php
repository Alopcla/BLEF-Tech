<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use App\Models\ZoneEvent;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function index()
    {
        $zones = Zone::all();
        $alerts = ZoneEvent::orderBy('created_at', 'desc')->get();

        // Cambiamos 'alerts.index' por 'alerts.alerts'
        return view('alerts.alerts', compact('zones', 'alerts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'zone_type' => 'required|string',
            'title' => 'required|string|max:100',
            'message' => 'required|string',
            'level' => 'required|in:aviso,alerta,peligro',
        ]);

        ZoneEvent::create([
            'zone_type' => $request->zone_type,
            'title' => $request->title,
            'message' => $request->message,
            'level' => $request->level,
            'active' => true
        ]);

        return redirect()->back()->with('success', 'Alerta publicada en el mapa correctamente.');
    }

    public function destroy($id)
    {
        $alert = ZoneEvent::findOrFail($id);
        $alert->delete();

        return redirect()->back()->with('success', 'Alerta eliminada del sistema.');
    }
}
