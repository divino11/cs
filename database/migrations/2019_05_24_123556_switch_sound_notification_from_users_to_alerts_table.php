<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SwitchSoundNotificationFromUsersToAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('sound_enable');
            $table->dropColumn('sound');
        });

        Schema::table('alerts', function (Blueprint $table) {
            $table->boolean('sound_enable')->nullable()->after('triggered_at');
            $table->string('sound')->nullable()->after('sound_enable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('sound_enable')->nullable()->after('password');
            $table->string('sound')->nullable()->after('sound_enable');
        });

        Schema::table('alerts', function (Blueprint $table) {
            $table->dropColumn('sound_enable');
            $table->dropColumn('sound');
        });
    }
}
