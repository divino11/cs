<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('password')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_verification_code')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->integer('sms')->nullable();
            $table->string('notification_email')->nullable();
            $table->timestamp('notification_email_verified_at')->nullable();
            $table->string('pushover')->nullable();
            $table->string('pushover_verification_code')->nullable();
            $table->timestamp('pushover_verified_at')->nullable();
            $table->string('telegram')->nullable();
            $table->string('telegram_verification_code')->default(rand(100000, 999999));
            $table->timestamp('telegram_verified_at')->nullable();
            $table->string('timezone')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
