<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_survey', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')
                ->constrained('patient_profiles')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('question_id')
                ->constrained('survey_questions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('answer');
            $table->integer('point');
            $table->foreignId('survey_id')
                ->constrained('surveys')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->integer('order');
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
        Schema::dropIfExists('patient_survey');
    }
}
