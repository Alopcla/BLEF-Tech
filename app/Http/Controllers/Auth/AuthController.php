<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // ── Formularios ──────────────────────────
    public function showLogin()    { return view('auth.login'); }
    public function showRegister() { return view('auth.register'); }

    // ── LOGIN ────────────────────────────────
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        // 1. ¿Es empleado?
        if (Auth::guard('employee')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->route('verification.notice')
                ->with('success', '¡Bienvenido!');
        }

        // 2. ¿Es cliente?
        if (Auth::guard('web')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->route('verification.notice')
                ->with('success', '¡Bienvenido!');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.']);
    }

    // ── REGISTER (solo clientes) ─────────────
    public function register(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        return redirect()->route('verification.notice')
            ->with('success', '¡Cuenta creada con éxito!');
    }

    // ── LOGOUT ───────────────────────────────
    public function logout(Request $request)
    {
        Auth::guard('employee')->logout();
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Sesión cerrada correctamente.');
    }
}