<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentNewsEventView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW vcos_content_news_event AS (
                SELECT 
                    cont.id AS id,
                    users_id,
                    name,
                    title,
                    cont.picture as picture,
                    CASE
                        WHEN cont.flag_active = 'Y' THEN 'Active'
                        WHEN cont.flag_active = 'N' THEN 'Non Active'
                        ELSE 'Non Active'
                    END AS flag_active,
                    cont.created_at AS created_at
                FROM dcos_content_news_event cont
                LEFT JOIN dcos_users user ON cont.users_id = user.id
            )
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS vcos_content_banner");
    }
}
