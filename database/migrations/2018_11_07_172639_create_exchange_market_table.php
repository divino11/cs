<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangeMarketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_market', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('exchange_id');
            $table->unsignedInteger('market_id');
            $table->foreign('exchange_id')->references('id')->on('exchanges')->onDelete('cascade');
            $table->foreign('market_id')->references('id')->on('markets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchange_market');
    }
}
