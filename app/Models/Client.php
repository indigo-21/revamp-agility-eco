<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clientJobType(): HasMany
    {
        return $this->hasMany(ClientJobType::class);
    }

    public function clientKeyDetails(): HasOne
    {
        return $this->hasOne(ClientKeyDetail::class);
    }

    public function clientInstallers(): HasMany
    {
        return $this->hasMany(ClientInstaller::class);
    }

    public function clientSlaMetric(): HasOne
    {
        return $this->hasOne(ClientSlaMetric::class);
    }

    public function clientType(): BelongsTo
    {
        return $this->belongsTo(ClientType::class);
    }

    public function chargingScheme(): BelongsTo
    {
        return $this->belongsTo(ChargingScheme::class);
    }

    public static function getClientData()
    {
        $result_data = self::select([
            'clients.id as client_id',
            'users.id as client_user_id',
            'users.firstname as client_name',
            'users.email as client_email',
            'users.mobile as client_mobile',
            'clients.client_abbrevation as client_tla',
            'clients.address1 as client_address1',
            'clients.address2 as client_address2',
            'clients.address3 as client_address3',
            'clients.city as client_city',
            'clients.country as client_country',
            'clients.postcode as client_postcode',
            'client_types.id as client_type_id',
            'client_types.name as client_type',
            'client_key_details.is_active as is_active',
        ]);
        $result_data->leftJoin('users', 'clients.user_id', '=', 'users.id');
        $result_data->leftJoin('client_types', 'clients.client_type_id', '=', 'client_types.id');
        $result_data->leftJoin('client_key_details', 'clients.id', '=', 'client_key_details.client_id');

        return $result_data->get();
    }



}
