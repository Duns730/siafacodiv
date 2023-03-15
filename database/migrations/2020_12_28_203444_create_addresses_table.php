<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('municipalities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('state_id');
            $table->string('name');
            $table->timestamps();
            $table->foreign('state_id')->references('id')->on('states');
        });

        Schema::create('population_centers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('municipality_id');
            $table->string('name');
            $table->timestamps();
            $table->foreign('municipality_id')->references('id')->on('municipalities');
        });

        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('population_center_id');
            $table->string('name');
            $table->timestamps();
            $table->foreign('population_center_id')->references('id')->on('population_centers');
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('municipality_id');
            $table->unsignedBigInteger('population_center_id');
            $table->unsignedBigInteger('location_id');
            $table->morphs('addressable');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('municipality_id')->references('id')->on('municipalities');
            $table->foreign('population_center_id')->references('id')->on('population_centers');
            $table->foreign('location_id')->references('id')->on('locations');
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
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('population_centers');
        Schema::dropIfExists('municipalities');
        Schema::dropIfExists('states');
    }
}
