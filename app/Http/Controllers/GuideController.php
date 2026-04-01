<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReserveExperience;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class GuideController extends Controller
{
    public function getGuideData()
    {
        $user = Auth::user();
        $employee = Employee::where('email', $user->email)->first();

        if (!$employee) {
            return response()->json(['guide' => null, 'reservations' => []]);
        }

        // Cargamos las reservas junto con los datos de la experiencia.
        // Si es Admin, ve todas. Si es Guía, solo las que tienen su DNI.
        $query = ReserveExperience::with('experience');

        if ($employee->position !== 'Administrador') {
            $query->where('employee_guide_dni', $employee->dni);
        }

        $reservations = $query->orderBy('reservation_date', 'asc')->get();

        return response()->json([
            'guide' => $employee,
            'reservations' => $reservations
        ]);
    }

    public function completeExperience(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reserve_experiences,id'
        ]);

        $reservation = ReserveExperience::findOrFail($request->reservation_id);

        // Cambiamos el status a false para marcarlo como completado
        $reservation->update([
            'status' => false
        ]);

        return response()->json(['success' => true, 'message' => 'Experiencia completada']);
    }
}
