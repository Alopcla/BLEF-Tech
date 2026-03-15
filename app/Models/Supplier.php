<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'province',
        'country',
        'email'
    ];

    // Relación 1:N -> Un proveedor nos surte de muchos productos
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
