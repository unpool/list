<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * - id
    - user_id
    - price
    - discount_price
    - is_paid
    - created_at
    - updated_at
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->double('price', 8, 2);
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->double('discount_price', 8, 2)->nullable();
            $table->boolean('is_paid');
            $table->string('send_type', 64)->nullable();
            $table->string('type', 64);
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
        Schema::dropIfExists('orders');
    }
}
