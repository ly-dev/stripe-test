<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->timestamps(); // when
            $table->increments('id');
            $table->integer('user_id')->unsigned(); // who
            $table->string('ip_address')->nullable(); // where
            $table->integer('severity')->unsigned(); // what
            $table->string('category'); // what
            $table->string('activity')->nullable(); // what
            $table->string('target_id')->nullable(); // what
            $table->binary('data')->nullable(); // what

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('audit_logs');
    }
}
