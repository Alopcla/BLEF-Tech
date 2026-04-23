<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderVerificationController extends Controller
{
    // Paso 1: recibe el email, genera el código y lo manda
    public function sendCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $email = $request->email;

        // Buscamos si hay un usuario con ese email
        $user = User::where('email', $email)->first();

        // Generamos el código de 6 dígitos
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expires = now()->addMinutes(10);

        if ($user) {
            // Si tiene cuenta, guardamos en su registro
            $user->update([
                'verification_code'            => $code,
                'verification_code_expires_at' => $expires,
            ]);
        } else {
            // Si no tiene cuenta, usamos password_reset_tokens como almacén temporal
            // (ya existe la tabla y tiene email + token + created_at)
            \DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $email],
                ['token' => $code, 'created_at' => now()]
            );
        }

        Mail::to($email)->send(new VerificationCodeMail($code));

        return response()->json(['message' => 'Código enviado']);
    }

    // Paso 2: verifica el código y devuelve un token de acceso temporal
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code'  => 'required|string|size:6',
        ]);

        $email = $request->email;
        $code  = $request->code;

        $user = User::where('email', $email)->first();

        if ($user) {
            // Verificación contra la tabla users
            if ($user->verification_code_expires_at && now()->isAfter($user->verification_code_expires_at)) {
                return response()->json(['error' => 'El código ha expirado'], 422);
            }
            if ($user->verification_code !== $code) {
                return response()->json(['error' => 'Código incorrecto'], 422);
            }
            // Limpiamos el código una vez usado
            $user->update([
                'verification_code'            => null,
                'verification_code_expires_at' => null,
            ]);
        } else {
            // Verificación contra password_reset_tokens
            $record = \DB::table('password_reset_tokens')
                ->where('email', $email)
                ->first();

            if (!$record) {
                return response()->json(['error' => 'No se encontró ningún código para este email'], 422);
            }
            // Los tokens en esta tabla expiran a los 10 min (usamos created_at)
            if (now()->diffInMinutes($record->created_at) > 10) {
                return response()->json(['error' => 'El código ha expirado'], 422);
            }
            if ($record->token !== $code) {
                return response()->json(['error' => 'Código incorrecto'], 422);
            }
            // Limpiamos
            \DB::table('password_reset_tokens')->where('email', $email)->delete();
        }

        // Generamos un token temporal firmado (válido 1 hora) para que el frontend
        // pueda llamar a /api/compras sin requerir login
        $accessToken = encrypt($email . '|' . now()->addHour()->timestamp);

        return response()->json(['access_token' => $accessToken]);
    }
}