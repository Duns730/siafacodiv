<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientPurchaseProformasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_purchase_proformas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('purchase_id');
            $table->unsignedBigInteger('proforma_id');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('purchase_id')->references('id')->on('purchases');
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
        Schema::dropIfExists('client_purchase_proformas');
    }
}
