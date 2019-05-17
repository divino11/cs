<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SwitchToLastPriceTableTickers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickers', function (Blueprint $table) {
            $table->dropColumn('bid');
            $table->dropColumn('ask');
            $table->decimal('last', 16,8)->nullable()->after('market_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickers', function (Blueprint $table) {
            $table->dropColumn('last');
            $table->decimal('bid', 16,8)->nullable()->after('market_id');
            $table->decimal('ask', 16,8)->nullable()->after('bid');
        });
    }
}
