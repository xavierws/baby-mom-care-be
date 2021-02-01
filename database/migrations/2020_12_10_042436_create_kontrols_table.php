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
            $table->float('weight')->nullable();
            $table->float('length')->nullable();
            $table->float('lingkar_kepala')->nullable();
            $table->float('temperature');
            $table->foreignId('patient_profile_id')
                ->constrained('patient_profiles')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('note', 500)->nullable();
            $table->string('nurse_note', 500)->nullable();
            $table->string('mode');
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
        Schema::dropIfExists('kontrols');
    }
}
