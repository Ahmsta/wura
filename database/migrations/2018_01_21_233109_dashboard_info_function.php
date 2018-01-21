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
            DROP FUNCTION dashboard_info;

            CREATE OR REPLACE FUNCTION dashboard_info (userid INT) RETURNS TABLE (
                expiredcards bigint, deletedcards bigint,
                activecards bigint, inactivedcards bigint,
                activedrivers bigint, inactivedrivers bigint,
                pendingcardrequest bigint, disputedcards bigint,
                activewallets bigint, inactivewallets bigint
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
            (select count(*) from cards where holder = userid and status = 'Disputed') disputedcards,
            (select count(*) from wallets where \"belongsTo\" = userid and status = true) activewallets,
            (select count(*) from wallets where \"belongsTo\" = userid and status = false) inactivewallets
            
            from drivers where \"belongsTo\" = userid and status = 'Activate';
            
            END; $$ 
            
            LANGUAGE 'plpgsql';

            DROP FUNCTION get_freecards;

            CREATE OR REPLACE FUNCTION get_freecards (userid INT) RETURNS TABLE (
                value integer, text character varying(255)
            ) 
            AS $$
            BEGIN
            RETURN QUERY 
            
            select c.id as \"value\", cardnos as \"text\" from cards c where c.id not in 
            (select oncard from wallets w where w.\"belongsTo\" = userid) 
            and c.holder = userid and c.status = 'Activate' order by c.id;
            
            END; $$ 
            
            LANGUAGE 'plpgsql';

            -- DROP FUNCTION search_columns(text, name[], name[]);

            CREATE OR REPLACE FUNCTION search_columns(
                IN needle text,
                IN haystack_tables name[] DEFAULT '{}'::name[],
                IN haystack_schema name[] DEFAULT '{public}'::name[])

            RETURNS TABLE(schemaname text, tablename text, columnname text, rowctid text) AS
            \$BODY\$
            begin
                FOR schemaname,tablename,columnname IN
                    SELECT c.table_schema,c.table_name,c.column_name
                    FROM information_schema.columns c
                    JOIN information_schema.tables t ON
                    (t.table_name=c.table_name AND t.table_schema=c.table_schema)
                    WHERE (c.table_name=ANY(haystack_tables) OR haystack_tables='{}')
                    AND c.table_schema=ANY(haystack_schema)
                    AND t.table_type='BASE TABLE'
                LOOP
            /* EXECUTE format('SELECT ctid FROM %I.%I WHERE cast(%I as text)=%L', */
            EXECUTE format('SELECT ctid FROM %I.%I WHERE cast(%I as text) LIKE %L',
                schemaname, tablename, columnname, needle
            ) INTO rowctid;
            IF rowctid is not null THEN
                RETURN NEXT;
            END IF;
            END LOOP;
            END;
            \$BODY\$
            LANGUAGE plpgsql VOLATILE
            COST 100
            ROWS 1000;
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
