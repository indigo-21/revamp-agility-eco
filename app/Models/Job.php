<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    public function property(): HasOne
    {
        return $this->hasOne(Property::class);
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class);
    }

    public function jobMeasure(): HasOne
    {
        return $this->hasOne(JobMeasure::class);
    }

    public function installer(): BelongsTo
    {
        return $this->belongsTo(Installer::class);
    }

    public function jobType(): BelongsTo
    {
        return $this->belongsTo(JobType::class);
    }

    public function scheme(): BelongsTo
    {
        return $this->belongsTo(Scheme::class);
    }

    public function jobStatus(): BelongsTo
    {
        return $this->belongsTo(JobStatus::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
    public function propertyInspector(): BelongsTo
    {
        return $this->belongsTo(PropertyInspector::class);
    }

    public function completedJobs(): HasMany
    {
        return $this->hasMany(CompletedJob::class);
    }

    public function remediation(): HasMany
    {
        return $this->hasMany(Remediation::class);
    }

}
