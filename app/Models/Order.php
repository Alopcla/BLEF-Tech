<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'stripe_session_id',
        'total',
        'status',
    ];

    // Usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Items del pedido
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Total formateado
    public function getTotalFormattedAttribute()
    {
        return number_format($this->total, 2) . ' €';
    }

    // Pedidos pagados
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }
}