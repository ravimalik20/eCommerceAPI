<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CartMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("status", function ($table) {
            $table->increments("id");
            $table->string("name");
            $table->timestamps();
        });

        Schema::create("cart", function ($table) {
            $table->increments("id");
            $table->integer("user_id")->unsigned();
            $table->integer("status_id")->unsigned();

            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("status_id")->references("id")->on("status");

            $table->timestamps();
        });

        Schema::create("cart_product", function ($table) {
            $table->increments("id");
            $table->integer("cart_id")->unsigned();
            $table->integer("product_id")->unsigned();
            $table->integer("quantity")->unsigned();

            $table->foreign("cart_id")->references("id")->on("cart");
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
        Schema::drop("status");
        Schema::drop("cart");
        Schema::drop("cart_product");
    }
}
