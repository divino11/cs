<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsEmailToSmsVerificationCodeAndEmailToSmsVerifiedAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email_to_sms_verification_code')->nullable()->after('email_to_sms');
            $table->timestamp('email_to_sms_verified_at')->nullable()->after('email_to_sms_verification_code');
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
            $table->dropColumn('email_to_sms_verification_code');
            $table->dropColumn('email_to_sms_verified_at');
        });
    }
}
