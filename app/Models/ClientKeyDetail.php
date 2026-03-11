<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientKeyDetail extends Model
{
    public function chargingScheme()
    {
        return $this->belongsTo(ChargingScheme::class);
    }
}
