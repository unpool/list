<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelationInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void//
     */
    public function up()
    {
        Schema::table('invites', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('invited_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invites', function (Blueprint $table) {
            $table->dropForeign('user_id');
            $table->dropForeign('invited_id');
        });
    }
}
