<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            do {
                $model->id = str_pad(mt_rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);
            } while (self::where('id', $model->id)->exists());
        });
    }

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'user_name',
        'password',
        'remember_token',
        'phone',
        'age',
        'profile_image',
        'pin_code',
        'title',
        'subject',
        'status',
        'user_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getImageUrlAttribute()
    {
        if (! $this->profile_image) {
            return asset('images/default-profile.png');
        } else {
            return asset('storage/profile_images/'.$this->profile_image);
        }
    }

    public function roles()
    {
        return $this->belongsToMany(role::class);
    }

    public function tickets()
    {
        return $this->hasMany(ticket::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

        public function senttransactions()
    {
        return $this->hasMany(transaction::class, 'sender_id');
    }

    public function receivedtransactions()
    {
        return $this->hasMany(transaction::class, 'receiver_id');
    }

        public function products()
    {
        return $this->hasMany(product::class);
    }

    public function IsAdmin()
    {
        return $this->roles()->where('name', 'admin')->exists();
    }
}
