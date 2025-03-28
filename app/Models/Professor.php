<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    protected $primaryKey = 'user_id';
    protected $fillable = ['user_id', 'area'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}