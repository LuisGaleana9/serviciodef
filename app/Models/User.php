<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'role'
    ];

    public function password()
    {
        return $this->hasOne(Password::class, 'user_id');
    }

    public function professor()
    {
        return $this->hasOne(Professor::class, 'user_id');
    }
}