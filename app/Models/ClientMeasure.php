<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientMeasure extends Model
{
    public function measure(){
        return $this->belongsTo(Measure::class);
    }
}
