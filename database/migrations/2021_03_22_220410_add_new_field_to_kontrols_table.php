<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldToKontrolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kontrols', function (Blueprint $table) {
            $table->string('hasil_penunjang')->nullable()->after('nurse_note');
            $table->string('terapi_pulang')->nullable()->after('hasil_penunjang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kontrols', function (Blueprint $table) {
            $table->dropColumn('hasil_penunjang');
            $table->dropColumn('terapi_pulang');
        });
    }
}
