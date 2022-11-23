<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNegotiationProformasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('negotiation_proformas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('negotiation_id');
            $table->unsignedBigInteger('proforma_id');
            $table->foreign('negotiation_id')->references('id')->on('negotiations');
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
        Schema::dropIfExists('negotiation_proformas');
    }
}
