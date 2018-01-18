<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle', function (Blueprint $table) {
            $table->increments('id');
            $table->text('year');
            $table->text('type');
            $table->text('color');
            $table->text('model');
            $table->text('drive');
            $table->text('doors');
            $table->string('body');
            $table->text('fuel_type');
            $table->text('owner_name');
            $table->text('transmission');
            $table->date('purchase_date');
            $table->text('license_plate_number');
            $table->string('left_view')->nullable();
            $table->string('rear_view')->nullable();
            $table->string('right_view')->nullable();
            $table->string('frontal_view')->nullable();
            $table->softDeletesTz();
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
        Schema::drop('vehicle');
    }
}
