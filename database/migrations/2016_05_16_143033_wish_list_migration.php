<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WishListMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("wish_list", function ($table) {
            $table->increments("id");
            $table->integer("user_id")->unsigned();
            $table->integer("product_id")->unsigned();

            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("product_id")->references("id")->on("product");

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
        Schema::drop("wish_list");
    }
}
