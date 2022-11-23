<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProformasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proformas', function (Blueprint $table) {
            $table->id();
            $table->decimal('factor', 10,2);
            $table->decimal('tax_base_dollar', 10,2);
            $table->decimal('tax_base_bolivar', 20,2);
            $table->decimal('iva_dollar', 10,2);
            $table->decimal('iva_bolivar', 20,2);
            $table->decimal('total_operation_dollar', 10,2);
            $table->decimal('total_operation_bolivar', 20,2);
            $table->integer('total_items');
            $table->string('type_price');
            $table->boolean('provisional')->default(false);
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
        Schema::dropIfExists('proformas');
    }
}
