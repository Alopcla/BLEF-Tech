<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class VerifyCodeController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        if (Auth::guard('employee')->check()) {
            $user = Auth::guard('employee')->user();
            $redirectTo = route('dashboard');
        } elseif (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            $redirectTo = route('welcome');
        } else {
            return redirect()->route('login')
                ->withErrors(['code' => 'Sesión expirada, vuelve a iniciar sesión.']);
        }

        if ($user->verification_code_expires_at && now()->isAfter($user->verification_code_expires_at)) {
            return back()->withErrors(['code' => 'El código ha expirado. Solicita uno nuevo.']);
        }

        if ($request->code !== $user->verification_code) {
            return back()->withErrors(['code' => 'Código incorrecto.']);
        }

        $user->update([
            'verification_code'            => null,
            'verification_code_expires_at' => null,
            'email_verified_at'            => now(),
        ]);

        return redirect($redirectTo)->with('success', '¡Bienvenido a BLR Zoo, ' . $user->name . '!');
    }
}