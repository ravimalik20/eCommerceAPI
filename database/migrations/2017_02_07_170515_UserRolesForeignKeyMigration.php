<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserRolesForeignKeyMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("users", function ($table) {
            $table->dropForeign("users_role_id_foreign");

            $table->foreign("role_id")->references("id")->on("user_roles");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("users", function ($table) {
            $table->dropForeign("users_role_id_foreign");

            $table->foreign("role_id")->references("id")->on("users");
        });
    }
}
