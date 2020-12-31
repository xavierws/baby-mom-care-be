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
            $table->integer('order');
            $table->date('date');
            $table->string('tempat_kontrol');
            $table->integer('weight')->nullable();
            $table->integer('length')->nullable();
            $table->integer('lingkar_kepala')->nullable();
            $table->integer('temperature');
            $table->foreignId('patient_profile_id');
            $table->string('note', 500)->nullable();
            $table->string('nurse_note', 500)->nullable();
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
