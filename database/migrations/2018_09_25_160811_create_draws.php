<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDraws extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draws', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('practise_id');
            $table->string('teamA')->nullable()->default(null);
            $table->string('teamB')->nullable()->default(null);
            $table->unsignedInteger('drawer_id');
            $table->foreign('drawer_id')->references('id')->on('users');
            $table->foreign('practise_id')->references('id')->on('practises');
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
        Schema::dropIfExists('draws');
    }
}
