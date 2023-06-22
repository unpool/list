<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddScoreColumnToNodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('nodes', 'score')) {
            Schema::table('nodes', function (Blueprint $table) {
                $table->integer('score')->default(0);
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
        if (Schema::hasColumn('nodes', 'score')) {
            Schema::table('nodes', function (Blueprint $table) {
                $table->dropColumn(['score']);
            });
        }
    }
}
