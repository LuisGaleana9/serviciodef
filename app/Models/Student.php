<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Schedule; 

class Student extends Model
{
    protected $primaryKey = 'user_id';
    
    protected $fillable = [
        'user_id', 
        'estado_servicio'   
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relacion de estudiante con su horario
    public function schedules()
{
    // Indicamos la clave foránea en la tabla 'schedules' y la clave local en 'students'
    return $this->hasMany(Schedule::class, 'student_user_id', 'user_id')
                ->orderBy('day_of_week')
                ->orderBy('start_time');
}
}