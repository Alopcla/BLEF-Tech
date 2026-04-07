<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'cod_ticket',
        'visit_day',
        'price',
        'total_order_amount',
        'stripe_session_id',
        'status',
    ];

    protected $casts = [
        'visit_day' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function availableForDate($date)
    {
        $vendidos = self::where('visit_day', $date)
            ->where('status', 'paid')
            ->count();

        return max(0, 10 - $vendidos);
    }

    /**
     * Comprueba si el usuario tiene permiso para reservar (si existe ticket pagado)
     */
    public static function hasticket($email)
    {
        if (!$email) return false;

        // Directamente self::where, sin llamar a table()
        return self::where('email', $email)
                ->where('status', 'paid')
                // Opcional: añadir que el ticket sea para hoy o futuro
                ->where('visit_day', '>=', now()->format('Y-m-d'))
                ->exists();
    }
}