<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validamos todos los campos que requiere tu tabla de clientes
        $request->validate([
            'dni' => ['required', 'string', 'max:20', 'unique:customers,dni'], // Validamos DNI
            'user_name' => ['required', 'string', 'max:255', 'unique:customers,user_name'], // Validamos Nickname
            'name' => ['required', 'string', 'max:255'],
            'surnames' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class, 'unique:customers,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::transaction(function () use ($request) {

            // A) Creamos la cuenta en el llavero (users)
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // B) Creamos su perfil de cliente en tu tabla (Customer)
            Customer::create([
                'dni' => $request->dni,
                'user_name' => $request->user_name,
                'name' => $request->name,
                'surnames' => $request->surnames,
                'email' => $request->email,
                'address' => $request->address,
                // 'category' => 'Estándar', // Descomenta esto si quieres asignar una categoría por defecto
            ]);

            // C) Logueamos al cliente
            event(new Registered($user));
            Auth::login($user);

        });

        return redirect(route('dashboard', absolute: false));
    }
}
