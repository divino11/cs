<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertNotificationChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alert_notification_channels', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('alert_id');
            $table->tinyInteger('notification_channel');
            $table->timestamp('created_at')->nullable();

            $table->foreign('alert_id')->references('id')->on('alerts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alert_notification_channels');
    }
}
