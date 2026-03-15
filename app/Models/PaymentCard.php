<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_dni',
        'card_type',
        'card_number',
        'expiration_date',
        'cvv'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_dni', 'dni');
    }
}
