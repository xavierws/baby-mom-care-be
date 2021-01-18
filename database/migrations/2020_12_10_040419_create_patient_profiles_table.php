<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientProfilesTable extends Migration
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
            $table->float('born_weight');
            $table->float('born_length');
            $table->float('lingkar_kepala');
            $table->enum('baby_gender', ['male', 'female']);
            $table->integer('usia_gestas');
            $table->boolean('harapan_orangtua');
            $table->string('mother_name');
            $table->date('mother_birthday');
            $table->string('mother_religion');
            $table->string('mother_education');
            $table->string('mother_job');
            $table->string('paritas');
            $table->enum('jumlah_anak', ['ld2', 'kds2']);
            $table->boolean('pengalaman_merawat');
            $table->boolean('tinggal_dengan_suami');
            $table->string('father_name');
            $table->date('father_birthday');
            $table->string('father_religion');
            $table->string('father_education');
            $table->string('father_job');
            $table->enum('pendapatan_keluarga', ['kd3', 'lds3']);
            $table->string('phone');
            $table->enum('status', ['hospital', 'home']);
            $table->dateTime('return_date')->nullable();
            $table->dateTime('marked_date')->nullable();
            $table->foreignId('hospital_id');
            $table->timestamps();

            $table->foreign('hospital_id')->references('id')->on('hospitals');
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
