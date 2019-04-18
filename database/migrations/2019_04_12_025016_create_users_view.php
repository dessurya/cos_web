<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW vcos_users AS (
                SELECT 
                    id,
                    name,
                    email,
                    login_count,
                    last_login,
                    CASE
                        WHEN flag_active = 'Y' THEN 'Active'
                        WHEN flag_active = 'N' THEN 'Non Active'
                        ELSE 'Non Active'
                    END AS flag_active
                FROM dcos_users
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
        DB::statement("DROP VIEW IF EXISTS vcos_users");
    }
}
