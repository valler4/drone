<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];
    public $incrementing = true;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

}
