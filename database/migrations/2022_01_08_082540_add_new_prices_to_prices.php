<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewPricesToPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->decimal('price_g', 10, 2);
            $table->decimal('price_h', 10, 2);
            $table->decimal('price_i', 10, 2);
            $table->decimal('price_j', 10, 2);
            $table->decimal('price_k', 10, 2);
            $table->decimal('price_l', 10, 2);
            $table->decimal('price_m', 10, 2);
            $table->decimal('price_n', 10, 2);
            $table->decimal('price_o', 10, 2);
            $table->decimal('price_p', 10, 2);
            $table->decimal('price_q', 10, 2);
            $table->decimal('price_r', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prices', function (Blueprint $table) {
            //
        });
    }
}
