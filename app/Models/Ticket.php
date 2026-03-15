<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_dni',
        'employee_dni',
        'date',
        'price'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_dni', 'dni');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_dni', 'dni');
    }
}
