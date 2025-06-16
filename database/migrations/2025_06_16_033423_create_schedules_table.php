<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_schedules_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            // Esta será la clave foránea que apunta a la tabla 'students'
            $table->unsignedBigInteger('student_user_id'); 
            $table->string('day_of_week'); // e.g., 'Lunes', 'Martes'
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

            // Definimos la restricción de clave foránea
            $table->foreign('student_user_id')->references('user_id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};