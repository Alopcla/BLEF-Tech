<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;
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
            $user = Auth::guard('employee')->user();
            $this->enviarCodigoVerificacion($user);
            return redirect()->route('verification.notice');
        }

        // 2. ¿Es cliente?
        if (Auth::guard('web')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::guard('web')->user();
            $this->enviarCodigoVerificacion($user);
            return redirect()->route('verification.notice');
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

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user = User::create([
            'name'                         => $request->name,
            'email'                        => $request->email,
            'password'                     => Hash::make($request->password),
            'verification_code'            => $code,
            'verification_code_expires_at' => now()->addMinutes(10),
        ]);

        Auth::guard('web')->login($user);
        $request->session()->regenerate(); // ← esto faltaba
        Mail::to($user->email)->send(new VerificationCodeMail($code));

        return redirect()->route('verification.notice');
    }

    // ── LOGOUT ───────────────────────────────
    public function logout(Request $request)
    {
        Auth::guard('employee')->logout();
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // ── HELPER: Generar y enviar código ──────
    private function enviarCodigoVerificacion($user): void
    {
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->update([
            'verification_code'            => $code,
            'verification_code_expires_at' => now()->addMinutes(10),
        ]);
        Mail::to($user->email)->send(new VerificationCodeMail($code));
    }

    public function reenviarCodigo(Request $request)
    {
        $user = Auth::guard('employee')->check()
            ? Auth::guard('employee')->user()
            : $request->user();

        $this->enviarCodigoVerificacion($user);

        return back()->with('status', 'verification-link-sent');
    }
}