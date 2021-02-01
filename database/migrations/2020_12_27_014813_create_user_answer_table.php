<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_answer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')
                ->constrained('patient_profiles')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('answer_id')
                ->constrained('question_choices')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->integer('point');
            $table->foreignId('question_id')
                ->constrained('questions')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('quiz_id')
                ->constrained('quizzes')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_answer');
    }
}
