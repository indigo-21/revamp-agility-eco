<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientMeasure extends Model
{
    protected $fillable = [
        'client_id',
        'measure_id',
        'measure_cat',
        'measure_fee_value',
        'measure_fee_currency'
    ];

    public function measure(){
        return $this->belongsTo(Measure::class);
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }
}
