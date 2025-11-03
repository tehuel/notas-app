<?php

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
        Schema::create('student_student_group', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained()
                ->onDelete('cascade'); // Delete pivot entries if student is deleted

            $table->foreignId('student_group_id')
                ->constrained()
                ->onDelete('cascade'); // Delete pivot entries if student group is deleted

            $table->unique(['student_id', 'student_group_id'], 'student_student_group_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_student_group');
    }
};
