<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('titles', function (Blueprint $table) {
            $table->id();
            $table->string('tconst',16)->index();
            $table->string('title_type', 16)->nullable();
            $table->text('primary_title')->nullable();
            $table->text('original_title')->nullable();
            $table->string('is_adult',16)->nullable();
            $table->string('start_year', 16)->nullable();
            $table->string('end_year',16)->nullable();
            $table->string('runtime_minutes', 16)->nullable();
            $table->string('genres', 64)->nullable();
            $table->float('weight')->default(0)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('titles');
    }
}
