<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Experience;
use App\Models\Zone;
use Illuminate\Support\Facades\Auth;

class GuideController extends Controller
{
    public function getGuideData()
    {
        $user = Auth::user();
        $employee = Employee::where('email', $user->email)->first();

        // 1. NUEVA SEGURIDAD: Dejamos pasar tanto a Guías como a Administradores
        if (!$employee || !in_array($employee->position, ['Guía', 'Administrador'])) {
            return response()->json(['guide' => null, 'experiencias' => []]);
        }

        // 2. LA LÓGICA DE ROLES
        if ($employee->position === 'Administrador') {
            // Si es Admin, le devolvemos el catálogo completo del Zoo
            $experiencias = Experience::with('zone')->get();
        } else {
            // Si es Guía, seguimos filtrando solo por su zona asignada
            $experiencias = Experience::with('zone')->where('zone_id', $employee->zone_id)->get();
        }

        return response()->json([
            'guide' => $employee,
            'experiencias' => $experiencias,
            'zones' => Zone::all()
        ]);
    }
}
