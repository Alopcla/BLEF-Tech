<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZoneEvent extends Model
{
    protected $fillable = ['zone_type', 'title', 'message', 'level', 'active'];

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_type', 'type');
    }
}
