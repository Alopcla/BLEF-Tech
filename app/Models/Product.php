<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'name',
        'description',
        'price',
        'stock',
        'order_date'
    ];

    protected $casts = [
        'order_date' => 'date',
    ];

    // Relación N:1 -> Un producto viene de un proveedor
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
