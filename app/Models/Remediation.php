<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Remediation extends Model
{
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    public function completedJob(): BelongsTo
    {
        return $this->belongsTo(CompletedJob::class);
    }

    public function remediationFiles()
    {
        return $this->hasMany(RemediationFile::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
