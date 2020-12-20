<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKontrolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kontrols', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('date');
            $table->string('tempat_kontrol');
            $table->integer('weight');
            $table->integer('length');
            $table->integer('lingkar_kepala');
            $table->integer('temperature');
            $table->foreignId('patient_profile_id');
            $table->timestamps();

            $table->foreign('patient_profile_id')->references('id')->on('patient_profiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kontrols');
    }
}
