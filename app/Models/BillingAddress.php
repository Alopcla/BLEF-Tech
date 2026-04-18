<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_dni',
        'owner_name',
        'owner_surnames',
        'address',
        'postal_code'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_dni', 'dni');
    }
}
