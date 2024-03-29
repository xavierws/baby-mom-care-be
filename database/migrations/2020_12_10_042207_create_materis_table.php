<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materis', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('content');
            $table->string('content_url')->nullable();
            $table->string('video_url')->nullable();
            $table->string('doc_url')->nullable();
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('forum_id')->nullable()
                ->constrained('forums')
                ->nullOnDelete()
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
        Schema::dropIfExists('materis');
    }
}
