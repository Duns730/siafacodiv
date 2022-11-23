<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNegotiationInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('negotiation_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('negotiation_id');
            $table->unsignedBigInteger('invoice_id');
            $table->foreign('negotiation_id')->references('id')->on('negotiations');
            $table->foreign('invoice_id')->references('id')->on('invoices');
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
        Schema::dropIfExists('negotiation_invoices');
    }
}
