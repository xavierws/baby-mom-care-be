<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNurseProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nurse_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('working_exp');
            $table->integer('education');
            $table->integer('phone');
            $table->foreignId('hospital_id');
            $table->boolean('is_approved');
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
        Schema::dropIfExists('perawat_profiles');
    }
}
