<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NavigationAuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'account_level_id',
        'navigation_id',
        'navigation_link',
        'route_name',
        'uri',
        'method',
        'ip',
        'user_agent',
        'referer',
        'status_code',
        'allowed',
        'required_permission',
        'granted_permission',
    ];

    protected $casts = [
        'allowed' => 'boolean',
        'status_code' => 'integer',
        'required_permission' => 'integer',
        'granted_permission' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function accountLevel(): BelongsTo
    {
        return $this->belongsTo(AccountLevel::class);
    }

    public function navigation(): BelongsTo
    {
        return $this->belongsTo(Navigation::class);
    }
}
