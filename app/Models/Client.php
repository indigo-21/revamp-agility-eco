<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    public function clientJobType(): HasMany {
        return $this->hasMany(ClientJobType::class);
    }

    public function clientType(): BelongsTo {
        return $this->belongsTo(ClientType::class);
    }

    public function chargingScheme(): BelongsTo {
        return $this->belongsTo(ChargingScheme::class);
    }
}
