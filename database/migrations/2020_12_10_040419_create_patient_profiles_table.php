<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasienProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('baby_name');
            $table->date('baby_birthday');
            $table->integer('born_weight');
            $table->integer('born_length');
            $table->enum('baby_gender', ['male', 'female']);
            $table->string('mother_name');
            $table->date('mother_birthday');
            $table->string('mother_religion');
            $table->string('mother_education');
            $table->string('mother_job');
            $table->string('paritas');
            $table->string('father_name');
            $table->date('father_birthday');
            $table->string('father_religion');
            $table->string('father_education');
            $table->string('father_job');
            $table->enum('status', ['hospital', 'home']);
            $table->foreignId('hospital_id');
            $table->timestamps();

            $table->foreign('hospital_id')->references('id')->on('hospital');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pasien_profiles');
    }
}
