<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_docs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('doctypes');
            $table->date('expirydate');
            $table->string('notifytype');
            $table->integer('counter');
            $table->string('frequency');
            $table->string('docpath');
            $table->integer('vehicleid');
            $table->integer('ownerid');
            $table->string('status');
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
        Schema::dropIfExists('vehicle_docs');
    }
}
