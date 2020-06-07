<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('names', function (Blueprint $table) {
            $table->id();
            $table->string('nconst',12)->index();
            $table->string('primary_name')->nullable();
            $table->string('birth_year', 16)->nullable();
            $table->string('death_year', 16)->nullable();
            $table->string('primary_profession')->nullable();
            $table->string('known_for_titles')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('names');
    }
}
