<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWatchedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('watched', function (Blueprint $table) {
            $table->id();
            $table->string('tconst_id', 16)->unique()->index();
            $table->string('title_type');
            $table->unsignedBigInteger('user_id')->index();
            $table->timestamp('watched_at')->nullable();
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
        Schema::dropIfExists('watched');
    }
}
