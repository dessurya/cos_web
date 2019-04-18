<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersLogsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW vcos_users_logs AS (
                SELECT 
                    log.id AS id,
                    users_id,
                    name,
                    logs,
                    log.created_at AS created_at
                FROM dcos_users_logs log
                LEFT JOIN dcos_users user ON log.users_id = user.id
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
        DB::statement("DROP VIEW IF EXISTS vcos_users_logs");
    }
}
