<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update([
            'verification_code'            => $code,
            'verification_code_expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new VerificationCodeMail($code));

        return redirect()->route('verification.notice');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
