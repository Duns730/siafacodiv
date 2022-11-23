<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNegotiationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('negotiations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->text('details');
            $table->integer('days_interval');
            $table->integer('payment_installments');
            $table->integer('effective_percentage');
            $table->integer('transfer_percentage');
            $table->timestamp('proformed_date')->nullable();
            $table->timestamp('selection_warehouse_date')->nullable();
            $table->timestamp('debug_date')->nullable();
            $table->timestamp('invoice_date')->nullable();
            $table->timestamp('iva_payment_date')->nullable();
            $table->timestamp('warehouse_packing_date')->nullable();
            $table->timestamp('dispatch_date')->nullable();
            $table->timestamp('deliver_date')->nullable();
            $table->timestamp('full_payment')->nullable();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('negotiations');
    }
}
