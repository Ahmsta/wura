<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('middlename')->nullable();            
            $table->string('lastname');
            $table->string('idnumber');
            $table->string('mobilenumber');
            $table->string('email', 45)->nullable();
            $table->date('dateofbirth');         
            $table->string('passportpath');
            $table->integer('belongsTo');
            $table->string('identificationpath');
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
        Schema::dropIfExists('drivers');        
    }
}
