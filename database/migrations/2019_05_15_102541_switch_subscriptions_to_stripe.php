<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SwitchSubscriptionsToStripe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('stripe_id')->nullable()->after('updated_at');
            $table->dropColumn('braintree_id');
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('stripe_id')->after('name');
            $table->string('stripe_plan')->after('stripe_id');
            $table->dropColumn('braintree_id');
            $table->dropColumn('braintree_plan');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('subscriptions');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('stripe_id');
            $table->dropColumn('paypal_email');
            $table->dropColumn('card_brand');
            $table->dropColumn('card_last_four');
            $table->dropColumn('trial_ends_at');
        });
    }
}
