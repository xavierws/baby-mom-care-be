<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->id();
            $table->string('notification');
            $table->foreignId('nurse_id')->nullable()
                ->constrained('nurse_profiles')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->enum('type', ['kontrol', 'advice','survey']);
//            $table->enum('for', ['nurse', 'patient']);
//            $table->foreignId('advice_id')->constrained('advices');
//            $table->foreignId('patient_profile_id')->constrained('patient_profiles');
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
        Schema::dropIfExists('notification_logs');
    }
}
