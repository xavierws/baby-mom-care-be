<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToPatientProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_profiles', function (Blueprint $table) {
            $table->string('diagnosa_medis')->after('phone')->nullable();
            $table->dateTime('hospital_entry')->after('marked_date')->nullable();
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
            //
        });
    }
}
