<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SwitchIntervalPeriodToEnumTableAlerts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $alerts = DB::table('alerts')->get();
        foreach ($alerts as $alert) {
            if (json_decode($alert->conditions)->interval_unit == 'minutes' || $alert->interval_unit == 'minutes') {
                DB::table('alerts')->where('conditions->interval_unit', 'minutes')->update(['conditions->interval_unit' => '0']);
                DB::table('alerts')->where('interval_unit', 'minutes')->update(['interval_unit' => '0']);
            } else if (json_decode($alert->conditions)->interval_unit == 'hours' || $alert->interval_unit == 'hours') {
                DB::table('alerts')->where('conditions->interval_unit', 'hours')->update(['conditions->interval_unit' => '1']);
                DB::table('alerts')->where('interval_unit', 'hours')->update(['interval_unit' => '1']);
            } else if (json_decode($alert->conditions)->interval_unit == 'days' || $alert->interval_unit == 'days') {
                DB::table('alerts')->where('conditions->interval_unit', 'days')->update(['conditions->interval_unit' => '2']);
                DB::table('alerts')->where('interval_unit', 'days')->update(['interval_unit' => '2']);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $alerts = DB::table('alerts')->get();
        foreach ($alerts as $alert) {
            if (json_decode($alert->conditions)->interval_unit == '0' || $alert->interval_unit == '0') {
                DB::table('alerts')->where('conditions->interval_unit', '0')->update(['conditions->interval_unit' => 'minutes']);
                DB::table('alerts')->where('interval_unit', '0')->update(['interval_unit' => 'minutes']);
            } else if (json_decode($alert->conditions)->interval_unit == '1' || $alert->interval_unit == '1') {
                DB::table('alerts')->where('conditions->interval_unit', '1')->update(['conditions->interval_unit' => 'hours']);
                DB::table('alerts')->where('interval_unit', '1')->update(['interval_unit' => 'hours']);
            } else if (json_decode($alert->conditions)->interval_unit == '2' || $alert->interval_unit == '2') {
                DB::table('alerts')->where('conditions->interval_unit', '2')->update(['conditions->interval_unit' => 'days']);
                DB::table('alerts')->where('interval_unit', '2')->update(['interval_unit' => 'days']);
            }
        }
    }
}

