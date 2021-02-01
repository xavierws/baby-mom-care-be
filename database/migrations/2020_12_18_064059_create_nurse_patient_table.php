<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNursePatientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nurse_patient', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nurse_id')
                ->constrained('nurse_profiles')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('patient_id')
                ->constrained('patient_profiles')
                ->cascadeOnUpdate()
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
        Schema::dropIfExists('nurse_patient');
    }
}
