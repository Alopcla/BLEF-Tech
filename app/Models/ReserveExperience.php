<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReserveExperience extends Model
{
    use HasFactory;

    protected $table = 'reserve_experiences';

    protected $fillable = [
        'experience_id',
        'ticket_id',
        'email',
        'reservation_date',
        'price',
        'stripe_session_id',
        'status',
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'price' => 'decimal:2',
    ];

    /*
    |-----------------------------
    | RELACIÓN: Experience
    |-----------------------------
    */
    public function experience()
    {
        return $this->belongsTo(Experience::class, 'experience_id');
    }

    /*
    |-----------------------------
    | SCOPES ÚTILES (opcional)
    |-----------------------------
    */

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}