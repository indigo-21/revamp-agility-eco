<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::deleting(function (User $user) {
            // Soft delete related records when user is soft deleted
            if ($user->isForceDeleting()) {
                // If force deleting, force delete related records too
                $user->client()?->forceDelete();
                $user->propertyInspector()?->forceDelete();
                $user->installer()?->forceDelete();
            } else {
                // Soft delete related records
                $user->client()?->delete();
                $user->propertyInspector()?->delete();
                $user->installer()?->delete();
            }
        });

        static::restoring(function (User $user) {
            // Restore related records when user is restored
            if ($user->client && $user->client->trashed()) {
                $user->client->restore();
            }
            if ($user->propertyInspector && $user->propertyInspector->trashed()) {
                $user->propertyInspector->restore();
            }
            if ($user->installer && $user->installer->trashed()) {
                $user->installer->restore();
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function client(){
        return $this->hasOne(Client::class);
    }

    public function propertyInspector()
    {
        return $this->hasOne(PropertyInspector::class);
    }
    
    public function installer()
    {
        return $this->hasOne(Installer::class);
    }
    
    public function accountLevel()
    {
        return $this->belongsTo(AccountLevel::class);
    }
    
    public function userType()
    {
        return $this->belongsTo(UserType::class);
    }

    /**
     * Send the password reset notification using our custom notification
     * which includes a BCC address.
     *
     * @param  string  $token
     * @return void
     */
    // public function sendPasswordResetNotification($token): void
    // {
    //     $this->notify(new ResetPasswordNotification($token));
    // }
}
