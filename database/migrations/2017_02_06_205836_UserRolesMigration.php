<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserRolesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("user_roles", function ($table) {
            $table->increments("id");
            $table->string("name");
            $table->timestamps();
        });

        Schema::table("users", function ($table) {
            $table->integer("role_id")->unsigned()->nullable();

            $table->foreign("role_id")->references("id")->on("users");
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
            $table->dropColumn("role_id");
        });

        Schema::drop("user_roles");
    }
}
