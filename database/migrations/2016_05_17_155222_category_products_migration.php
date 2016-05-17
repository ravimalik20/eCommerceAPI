<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoryProductsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("category_product", function ($table) {
            $table->increments("id");
            $table->integer("category_id")->unsigned();
            $table->integer("product_id")->unsigned();

            $table->foreign("category_id")->references("id")->on("category");
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
        Schema::drop("category_product");
    }
}
