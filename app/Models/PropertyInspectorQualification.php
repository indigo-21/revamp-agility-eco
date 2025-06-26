<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyInspectorQualification extends Model
{
    public function propertyInspector(): BelongsTo
    {
        return $this->belongsTo(PropertyInspector::class);
    }
}
