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
                expiredcards bigint, deletedcards bigint,
                activecards bigint, inactivedcards bigint,
                activedrivers bigint, inactivedrivers bigint,
                pendingcardrequest bigint, disputedcards bigint
            ) 
            AS $$
            BEGIN
            RETURN QUERY 
            
            -- Do not return cards that have expired and cards that have been deleted
            -- update cards set status = 'Expired' where valid_until < current_timestamp;
            
            select count(*) activedrivers,
            (select count(*) from drivers where \"belongsTo\" = userid and status <> 'Activate' and deleted_at is null) inactivedrivers,
            (select count(*) from cards where holder = userid and status = 'Activate') activecards,
            (select count(*) from cards where holder = userid and status = 'Suspend') inactivedcards,
            (select count(*) from cards where holder = userid and status = 'Expired') expiredcards,
            (select count(*) from cards where holder = userid and status = 'Deleted' and deleted_at is not null) deletedcards,
            (select count(*) from cards where holder = userid and status = 'Processing Request') pendingcardrequest,
            (select count(*) from cards where holder = userid and status = 'Disputed') disputedcards
            
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
        DB::unprepared("DROP FUNCTION dashboard_info");
    }
}
