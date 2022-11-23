<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditNoteProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_note_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('credit_note_id');
            $table->unsignedBigInteger('invoice_product_id');
            $table->integer('quantity');
            $table->decimal('total_price_bolivar', 20,2);
            $table->decimal('total_price_dollar', 10,2);
            $table->foreign('credit_note_id')->references('id')->on('credit_notes');
            $table->foreign('invoice_product_id')->references('id')->on('invoice_products');
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
        Schema::dropIfExists('credit_note_products');
    }
}
