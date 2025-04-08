<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyInspectorPostcode extends Model
{
    public function outwardPostcode()
    {
        return $this->belongsTo(OutwardPostcode::class);
    }
}
