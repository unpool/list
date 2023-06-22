<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelationOrderablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orderables', function (Blueprint $table) {
//            $table->foreign('nodeable_id')->references('id')->on('plans');
            $table->foreign('order_id')->references('id')->on('orders');
//            $table->foreign('nodeable_id')->references('id')->on('nodes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orderables', function (Blueprint $table) {
            $table->dropForeign('order_id');
//            $table->dropForeign('nodeable_id');
        });
    }
}
