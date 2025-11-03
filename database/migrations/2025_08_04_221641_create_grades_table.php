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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();

            $table->foreignId('assessment_id')
                ->constrained()
                ->onDelete('cascade');

            $table->morphs('gradable'); // Polymorphic relation to Student or StudentGroup

            // Type of grading ('numeric', 'pass_fail', 'letter')
            $table->string('type')
                ->default('numeric');

            $table->string('value')
                ->nullable();

            $table->text('comment')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
