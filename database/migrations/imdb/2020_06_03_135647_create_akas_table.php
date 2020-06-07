<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akas', function (Blueprint $table) {
            $table->id();
            $table->string('title_id', 16)->index();
            $table->string('ordering', 16)->nullable();
            $table->text('title')->nullable();
            $table->string('region', 16)->nullable();
            $table->string('language', 16)->nullable();
            $table->string('types', 32)->nullable();
            $table->string('attributes')->nullable();
            $table->string('is_original_title', 16)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akas');
    }
}
