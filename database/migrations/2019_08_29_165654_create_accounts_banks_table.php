<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * - id
    - user_id
    - firs_name
    - last_name
    - account_number
    - created_at
    - updated_at
     */
    public function up()
    {
        Schema::create('accounts_banks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('first_name', 64);
            $table->string('last_name', 64);
            $table->string('account_number', 32);
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
        Schema::dropIfExists('accounts_banks');
    }
}
