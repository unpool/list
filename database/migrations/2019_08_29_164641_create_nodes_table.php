<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nodes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 128);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('left')->nullable()->index();
            $table->unsignedBigInteger('right')->nullable()->index();
            $table->integer('depth')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->integer('sell')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nodes');
    }
}
