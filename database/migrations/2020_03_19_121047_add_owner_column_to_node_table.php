<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOwnerColumnToNodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('nodes', 'ownerable_id')) {
            Schema::table('nodes', function (Blueprint $table) {
                $table->unsignedBigInteger('ownerable_id')->nullable();
            });
        }
        if (!Schema::hasColumn('nodes', 'ownerable_type')) {
            Schema::table('nodes', function (Blueprint $table) {
                $table->string('ownerable_type', 200)->nullable();
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
        Schema::table('nodes', function (Blueprint $table) {
            $table->dropColumn(['ownerable_id', 'ownerable_type']);
        });
    }
}
