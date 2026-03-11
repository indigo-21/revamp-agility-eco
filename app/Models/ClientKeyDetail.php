<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientKeyDetail extends Model
{
    protected $fillable = [
        'client_id',
        'is_active',
        'can_job_outcome_appealed',
        'charging_scheme_id',
        'payment_terms',
        'charge_by_property_rate',
        'currency',
    ];

    public function chargingScheme()
    {
        return $this->belongsTo(ChargingScheme::class);
    }
}
