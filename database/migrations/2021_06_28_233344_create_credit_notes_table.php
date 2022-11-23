<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_notes', function (Blueprint $table) {
            $table->id();
            $table->string('note_number');
            $table->string('control_number');
            $table->string('invoices');
            $table->date('date');
            $table->decimal('tax_base_dollar', 10,2);
            $table->decimal('tax_base_bolivar', 20,2);
            $table->decimal('iva_dollar', 10,2);
            $table->decimal('iva_bolivar', 20,2);
            $table->decimal('total_operation_dollar', 10,2);
            $table->decimal('total_operation_bolivar', 20,2);
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
        Schema::dropIfExists('credit_notes');
    }
}
