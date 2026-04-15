<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name'              => $googleUser->getName(),
                'google_id'         => $googleUser->getId(),
                'password'          => bcrypt(str()->random(24)),
                'email_verified_at' => now(), // 👈 Google ya verificó el email, lo marcamos directamente
            ]
        );

        Auth::login($user);

        return redirect('/')->with('success', '¡Bienvenido, ' . $user->name . '! Has iniciado sesión correctamente.');
    }
}
