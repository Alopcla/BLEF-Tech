<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'price',
        'type',
        'date_used'
    ];

    protected $casts = [
        'date' => 'date',
        'date_used' => 'date'
    ];
}
