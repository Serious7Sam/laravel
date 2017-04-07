<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    const TABLE_PRODUCT = 'product';
    const TABLE_PRODUCT_VOUCHER = 'product_voucher';
    const TABLE_VOUCHER = 'voucher';
    const TABLE_DISCOUNT = 'discount';

    public function up()
    {
        $this->createProductTable();
        $this->createDiscountTable();
        $this->createVoucherTable();

        $this->createProductVoucherTable();
    }

    public function down()
    {
        Schema::drop(self::TABLE_PRODUCT_VOUCHER);
        Schema::drop(self::TABLE_PRODUCT);
        Schema::drop(self::TABLE_VOUCHER);
        Schema::drop(self::TABLE_DISCOUNT);
    }

    private function createProductTable()
    {
        Schema::create(self::TABLE_PRODUCT, function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 200);
            $table->decimal('price', 17,4);
            $table->unsignedTinyInteger('is_active');

            $table->unique('name');
            $table->index(['is_active', 'price']);
        });
    }

    private function createVoucherTable()
    {
        Schema::create(self::TABLE_VOUCHER, function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('discount_id');
            $table->date('start_date');
            $table->date('end_date');

            $table->foreign('discount_id')
                ->references('id')
                ->on(self::TABLE_DISCOUNT);
        });
    }

    private function createDiscountTable()
    {
        Schema::create(self::TABLE_DISCOUNT, function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 200);
            $table->decimal('value', 17, 4);
        });
    }

    private function createProductVoucherTable()
    {
        Schema::create(self::TABLE_PRODUCT_VOUCHER, function(Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('voucher_id');

            $table->primary(['product_id', 'voucher_id']);

            $table->foreign('product_id')
                ->references('id')
                ->on(self::TABLE_PRODUCT)
                ->onDelete('cascade');

            $table->foreign('voucher_id')
                ->references('id')
                ->on(self::TABLE_VOUCHER)
                ->onDelete('cascade');
        });
    }
}
