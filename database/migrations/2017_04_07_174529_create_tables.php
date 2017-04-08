<?php

use App\Entity\Discount;
use App\Entity\Product;
use App\Entity\Voucher;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTables extends Migration
{
    public function up()
    {
        $this->createProductTable();
        $this->createDiscountTable();
        $this->createVoucherTable();

        $this->createProductVoucherTable();
    }

    public function down()
    {
        Schema::drop(Product::TABLE_PRODUCT_VOUCHERS);
        Schema::drop(Product::TABLE_NAME);
        Schema::drop(Voucher::TABLE_NAME);
        Schema::drop(Discount::TABLE_NAME);
    }

    private function createProductTable()
    {
        Schema::create(Product::TABLE_NAME, function(Blueprint $table) {
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
        Schema::create(Voucher::TABLE_NAME, function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('discount_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedTinyInteger('is_active');

            $table->foreign('discount_id')
                ->references('id')
                ->on(Discount::TABLE_NAME);
        });
    }

    private function createDiscountTable()
    {
        Schema::create(Discount::TABLE_NAME, function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 200);
            $table->decimal('value', 17, 4);
        });
    }

    private function createProductVoucherTable()
    {
        Schema::create(Product::TABLE_PRODUCT_VOUCHERS, function(Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('voucher_id');

            $table->primary(['product_id', 'voucher_id']);

            $table->foreign('product_id')
                ->references('id')
                ->on(Product::TABLE_NAME)
                ->onDelete('cascade');

            $table->foreign('voucher_id')
                ->references('id')
                ->on(Voucher::TABLE_NAME)
                ->onDelete('cascade');
        });
    }
}
