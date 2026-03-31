<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'zone_id',
        'common_name',
        'species',
        'birth_date',
        'diet',
        'curiosity',
        'image',
        'last_fed_date',
        'last_fed_by',
        'food_ration'
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    // Relación N:1 -> Un animal pertenece a una zona
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    // Relación 1:N -> Un animal tiene muchos registros médicos
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }
}
