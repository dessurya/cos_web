<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentPageView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW vcos_content_page AS (
                SELECT 
                    id,
                    title,
                    picture,
                    CASE
                        WHEN flag_active = 'Y' THEN 'Active'
                        WHEN flag_active = 'N' THEN 'Non Active'
                        ELSE 'Non Active'
                    END AS flag_active,
                    created_at
                FROM dcos_content_page
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
        DB::statement("DROP VIEW IF EXISTS vcos_content_page");
    }
}
