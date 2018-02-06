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
            --DROP FUNCTION dashboard_info;

            CREATE OR REPLACE FUNCTION dashboard_info (userid INT) RETURNS TABLE (
                expiredcards bigint, deletedcards bigint,
                activecards bigint, inactivedcards bigint,
                activedrivers bigint, inactivedrivers bigint,
                pendingcardrequest bigint, disputedcards bigint,
                activewallets bigint, inactivewallets bigint,
                registeredvehicles bigint, expireddocuments bigint
            ) 
            AS $$
            BEGIN
            RETURN QUERY 
            
            -- Do not return cards that have expired and cards that have been deleted
            -- update cards set status = 'Expired' where valid_until < current_timestamp;
            
            select count(*) activedrivers,
            (select count(*) from drivers where ownerid = userid and status <> 'Activate' and deleted_at is null) inactivedrivers,
            (select count(*) from cards where ownerid = userid and status = 'Activate') activecards,
            (select count(*) from cards where ownerid = userid and status = 'Suspend') inactivedcards,
            (select count(*) from cards where ownerid = userid and status = 'Expired') expiredcards,
            (select count(*) from cards where ownerid = userid and status = 'Deleted' and deleted_at is not null) deletedcards,
            (select count(*) from cards where ownerid = userid and status = 'Processing Request') pendingcardrequest,
            (select count(*) from cards where ownerid = userid and status = 'Disputed') disputedcards,
            (select count(*) from wallets where ownerid = userid and status = true) activewallets,
            (select count(*) from wallets where ownerid = userid and status = false) inactivewallets,
            (select  count(*) from vehicle_docs where status = 'Expired' and ownerid = userid) expireddocuments,
            (select count(*) from vehicles where ownerid = userid) registeredvehicles
            
            from drivers where ownerid = userid and status = 'Activate';
            
            END; $$ 
            
            LANGUAGE 'plpgsql';

           -- DROP FUNCTION get_freecards;

            CREATE OR REPLACE FUNCTION get_freecards (userid INT) RETURNS TABLE (
                value integer, text character varying(255)
            ) 
            AS $$
            BEGIN
            RETURN QUERY 
            
            select c.id as \"value\", cardnos as \"text\" from cards c where c.id not in 
            (select oncard from wallets w where w.ownerid = userid) 
            and c.ownerid = userid and c.status = 'Activate' order by c.id;
            
            END; $$ 
            
            LANGUAGE 'plpgsql';

            -- FUNCTION: public.search_columns(text, name[], name[])

            -- DROP FUNCTION public.search_columns(text, integer, name[], name[]);

            CREATE OR REPLACE FUNCTION public.search_columns(
                needle text,
                userid integer,
                haystack_tables name[] DEFAULT '{}'::name[],
                haystack_schema name[] DEFAULT '{public}'::name[])
                RETURNS TABLE(schemaname text, tablename text, columnname text, rowctid text, results text) 
                LANGUAGE 'plpgsql'

                COST 100
                VOLATILE 
                ROWS 1000
            AS \$BODY\$

                begin
                    FOR schemaname,tablename,columnname IN
                        SELECT c.table_schema,c.table_name,c.column_name
                        FROM information_schema.columns c
                        JOIN information_schema.tables t ON
                        (t.table_name=c.table_name AND t.table_schema=c.table_schema)
                        WHERE (c.table_name=ANY(haystack_tables) OR haystack_tables='{}')
                        AND c.table_schema=ANY(haystack_schema)
                        AND t.table_type='BASE TABLE'
                        AND t.table_name NOT IN ('audits', 'failed_jobs', 'jobs', 'migrations', 'password_resets', 'users')
                    LOOP

                        EXECUTE format('SELECT ctid FROM %I.%I WHERE lower(cast(%I as text)) LIKE lower(cast(%L as text)) ',
                            schemaname, tablename, columnname, needle
                        ) INTO rowctid;
                        
                        IF rowctid is not null THEN
                            execute format('SELECT json_agg(result) FROM (
                                        SELECT * FROM %I.%I WHERE lower(cast(%I as text)) LIKE cast($1 as text) AND ownerid = $2) 
                                        as result', schemaname, tablename, columnname) INTO results USING lower(needle), userid;
                            RETURN NEXT;
                        END IF;
                    END LOOP;
                END;
                
            \$BODY\$;

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
