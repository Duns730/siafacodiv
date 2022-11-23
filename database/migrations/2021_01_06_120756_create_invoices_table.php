<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('seller_id');
            $table->string('factor');
            $table->string('invoice_number');
            $table->date('date');
            $table->boolean('provisional')->default(false);
            $table->decimal('tax_base_dollar', 10,2);
            $table->decimal('tax_base_bolivar', 20,2);
            $table->decimal('iva_dollar', 10,2);
            $table->decimal('iva_bolivar', 20,2);
            $table->decimal('total_operation_dollar', 10,2);
            $table->decimal('total_operation_bolivar', 20,2);
            $table->enum('status', ['PENDIENTE', 'ANULADA', 'CANCELADA'])->default('PENDIENTE');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('seller_id')->references('id')->on('sellers');
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
        Schema::dropIfExists('invoices');
    }
}
