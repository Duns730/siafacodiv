<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProformaProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proforma_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('proforma_id');
            $table->integer('position');
            $table->integer('quantity');
            $table->decimal('unit_price_bolivar', 20,2);
            $table->decimal('total_price_dollar', 10,2);
            $table->decimal('total_price_bolivar', 20,2);
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('proforma_id')->references('id')->on('proformas');
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
        Schema::dropIfExists('proforma_products');
    }
}
