<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Searchable;

    public function toSearchableArray()
    {
        return[
            'id'=>$this->id,
            'user_name'=>$this->user_name,
            'name'=>$this->name,
        ];
    }

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
        'bio',
        'country',
        'gender',
        'google_id',
    ];

    protected $keyType = 'string';

    public $incrementing = true;

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
        return $this->belongsToMany(Role::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

        public function senttransactions()
    {
        return $this->hasMany(Transaction::class, 'sender_id');
    }

    public function receivedtransactions()
    {
        return $this->hasMany(Transaction::class, 'receiver_id');
    }

        public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function IsAdmin()
    {
        return $this->roles()->where('name', 'admin')->exists();
    }
}
