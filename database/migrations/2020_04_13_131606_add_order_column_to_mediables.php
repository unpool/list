<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderColumnToMediables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('mediables', 'order')) {
            Schema::table('mediables', function (Blueprint $table) {
                $table->integer('order')->nullable()->default(null);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('mediables', 'order')) {
            Schema::table('mediables', function (Blueprint $table) {
                $table->dropColumn(['order']);
            });
        }
    }
}
