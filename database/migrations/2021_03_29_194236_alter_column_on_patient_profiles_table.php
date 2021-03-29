<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnOnPatientProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_profiles', function (Blueprint $table) {
            $table->integer('jumlah_anak')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_profiles', function (Blueprint $table) {
            $table->enum('jumlah_anak', ['ld2', 'kds2'])->change();
        });
    }
}
