<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLinkColumnToSliderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('sliders', 'link')) {
            Schema::table('sliders', function (Blueprint $table) {
                $table->string('link')->nullable();
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
        if (Schema::hasColumn('sliders', 'link')) {
            Schema::table('sliders', function (Blueprint $table) {
                $table->dropColumn(['link']);
            });
        }
    }
}
