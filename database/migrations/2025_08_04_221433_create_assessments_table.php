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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('course_id')
                ->constrained()
                ->onDelete('cascade'); // Delete assessment if course is deleted

            $table->string('title');
            $table->text('description')->nullable();

            // type of assessment ('individual', 'group')
            $table->string('type')
                ->default('individual');

            // Type of grading ('numeric', 'pass_fail')
            $table->string('grade_type')
                ->default('numeric');

            $table->unsignedTinyInteger('order')
                ->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
