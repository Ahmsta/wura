<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DashboardInfoFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE OR REPLACE FUNCTION dashboard_info (userid INT) RETURNS TABLE (
                activecards bigint, inactivedcards bigint,
            activedrivers bigint, inactivedrivers bigint
            ) 
            AS $$
            BEGIN
                RETURN QUERY 
                
                select count(*) activedrivers,
            (select count(*) from drivers where \"belongsTo\" = userid and status <> 'Activate' and deleted_at is null) inactivedrivers,
            (select count(*) from cards where holder = userid and status = 'Activate') activecards,
            (select count(*) from cards where holder = userid and status = 'Suspend') inactivedcards
            from drivers where \"belongsTo\" = userid and status = 'Activate';
            
            END; $$ 
                
            LANGUAGE 'plpgsql';
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
