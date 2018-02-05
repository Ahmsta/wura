<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
    */
    public function up()
    {
        Schema::table('calendars', function (Blueprint $table) {
            $table->renameColumn('owner', 'ownerid');
        });

        Schema::table('cards', function (Blueprint $table) {
            $table->renameColumn('holder', 'ownerid');
        });

        // Schema::table('drivers', function (Blueprint $table) {
        //     $table->renameColumn('belongsTo', 'ownerid');
        // });

        Schema::table('notifications', function (Blueprint $table) {
            $table->renameColumn('owner_id', 'ownerid');
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->renameColumn('owner', 'ownerid');
        });

        // Schema::table('wallets', function (Blueprint $table) {
        //     $table->renameColumn('belongsTo', 'ownerid');
        // });

        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('ownerid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
    */
    public function down()
    {
        Schema::table('calendars', function (Blueprint $table) {
            $table->renameColumn('ownerid', 'owner');
        });

        Schema::table('cards', function (Blueprint $table) {
            $table->renameColumn('ownerid', 'holder');
        });

        Schema::table('drivers', function (Blueprint $table) {
            $table->renameColumn('ownerid', 'belongsTo');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->renameColumn('ownerid', 'owner_id');
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->renameColumn('ownerid', 'owner');
        });

        Schema::table('wallets', function (Blueprint $table) {
            $table->renameColumn('ownerid', 'belongsTo');
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->integer('ownerid');
        });
    }
}
