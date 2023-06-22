<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveSomeColumnsFromDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('discounts', function (Blueprint $table) {
            if (Schema::hasColumn('discounts', 'discountable_id')) {
                $table->dropColumn(['discountable_id']);
            }
            if (Schema::hasColumn('discounts', 'discountable_type')) {
                $table->dropColumn(['discountable_type']);
            }
            if (Schema::hasColumn('discounts', 'is_global')) {
                $table->dropColumn(['is_global']);
            }
            if (!Schema::hasColumn('discounts', 'status')) {
                $table->tinyInteger('status')->nullable();
            }
            $table->text('value')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('discounts', function (Blueprint $table) {
            if (!Schema::hasColumn('discounts', 'discountable_id')) {
                $table->string('discountable_id', 128);
            }
            if (!Schema::hasColumn('discounts', 'discountable_type')) {
                $table->string('discountable_type', 128);
            }
            if (!Schema::hasColumn('discounts', 'is_global')) {
                $table->boolean('is_global');
            }
            if (Schema::hasColumn('discounts', 'status')) {
                $table->dropColumn(['status']);
            }
            if (Schema::hasColumn('discounts', 'value')) {
                $table->dropColumn(['value']);
                $table->string('value', 64);
            }
        });
    }
}
