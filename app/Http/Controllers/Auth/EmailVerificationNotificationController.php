<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        /** @var \App\Models\User $user */
        $user = $request->user();
        $user->update([
            'verification_code'            => $code,
            'verification_code_expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new VerificationCodeMail($code));

        return back()->with('status', 'verification-link-sent');
    }
}
