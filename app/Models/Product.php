<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'name',
        'description',
        'price',
        'stock',
        'category',
        'image',
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

    // Esto hace que 'image_url' aparezca siempre en el JSON
    protected $appends = ['image_url'];

public function getImageUrlAttribute()
{
    if (!$this->image) {
        return null;
    }

    // Si ya es URL completa
    if (filter_var($this->image, FILTER_VALIDATE_URL)) {
        return $this->image;
    }

    // Si empieza por /img (tu caso actual)
    if (str_starts_with($this->image, '/img')) {
        return $this->image;
    }

    // Si es storage normal
    return asset('storage/' . $this->image);
}
}
