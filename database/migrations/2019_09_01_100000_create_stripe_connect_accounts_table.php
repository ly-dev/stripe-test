<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStripeConnectAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strip_connect_accounts', function (Blueprint $table) {
            $table->timestamps();
            $table->increments('id');
            $table->string('token_type');
            $table->string('stripe_publishable_key');
            $table->string('scope');
            $table->boolean('livemode');
            $table->string('stripe_user_id')->unique();
            $table->string('refresh_token');
            $table->string('access_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('strip_connect_accounts');
    }
}
