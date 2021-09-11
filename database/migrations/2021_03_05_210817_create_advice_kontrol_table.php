<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdviceKontrolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advice_kontrol', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advice_id')
                ->constrained('advices')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('kontrol_id')
                ->constrained('kontrols')
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
        Schema::dropIfExists('advice_kontrol');
    }
}
