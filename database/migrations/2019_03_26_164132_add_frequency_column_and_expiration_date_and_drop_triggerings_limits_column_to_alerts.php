<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFrequencyColumnAndExpirationDateColumnAndDropTriggeringsLimitsColumnToAlerts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alerts', function (Blueprint $table) {
            $table->boolean('frequency')->nullable()->after('conditions');
            $table->timestamp('expiration_date')->nullable()->after('frequency');
            $table->dropColumn('triggerings_limits');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alerts', function (Blueprint $table) {
            $table->dropColumn('frequency');
            $table->dropColumn('expiration_date');
            $table->integer('triggerings_limit')->after('triggerings_number');
        });
    }
}
