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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->text('year');
            $table->text('make');
            $table->text('model');
            $table->text('trim');
            $table->text('color');
            $table->integer('owner');
            $table->text('owner_name');
            $table->date('purchase_date');
            $table->integer('assigned_to');
            $table->text('license_plate_number');
            $table->text('car_details')->nullable();
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
        Schema::drop('vehicles');
    }
}
