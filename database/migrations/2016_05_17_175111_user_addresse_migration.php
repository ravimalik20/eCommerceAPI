<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserAddresseMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("country", function ($table) {
            $table->increments("id");
            $table->string("name");
            $table->timestamps();
        });

        Schema::create("state", function ($table) {
            $table->increments("id");
            $table->string("name");
            $table->integer("country_id")->unsigned();
            $table->foreign("country_id")->references("id")->on("country");
            $table->timestamps();
        });

        Schema::create("user_address", function ($table) {
            $table->increments("id");
            $table->integer("user_id")->unsigned();
            $table->string("line1");
            $table->string("line2")->nullable();
            $table->string("city");
            $table->integer("state_id")->unsigned();
            $table->integer("country_id")->unsigned();
            $table->string("zipcode");
            $table->string("contact_name");
            $table->string("contact_number");

            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("state_id")->references("id")->on("state");
            $table->foreign("country_id")->references("id")->on("country");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("user_address");
        Schema::drop("state");
        Schema::drop("country");
    }
}
