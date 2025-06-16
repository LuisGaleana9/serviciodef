<?php

// app/Models/Schedule.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_user_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    /**
     * Obtiene el estudiante al que pertenece el horario.
     */
    public function student()
    {
        // Indicamos la clave foránea y la clave primaria de la tabla students
        return $this->belongsTo(Student::class, 'student_user_id', 'user_id');
    }
}