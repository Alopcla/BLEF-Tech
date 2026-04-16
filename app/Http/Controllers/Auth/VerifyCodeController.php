<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class VerifyCodeController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        /** @var \App\Models\User $user */
        $user = $request->user();

        // Código expirado
        if (now()->isAfter($user->verification_code_expires_at)) {
            return back()->withErrors(['code' => 'El código ha expirado. Solicita uno nuevo.']);
        }

        // Código incorrecto
        if ($request->code !== $user->verification_code) {
            return back()->withErrors(['code' => 'Código incorrecto.']);
        }

        // Todo correcto — limpiamos el código y marcamos email verificado
        $user->update([
            'verification_code'            => null,
            'verification_code_expires_at' => null,
            'email_verified_at'            => now(),
        ]);

        return redirect('/')->with('success', '¡Bienvenido a BLR Zoo, ' . $user->name . '! 🎉');
    }
}