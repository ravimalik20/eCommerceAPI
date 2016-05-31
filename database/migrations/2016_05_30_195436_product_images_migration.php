<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductImagesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("product_image", function ($table) {
            $table->increments("id");
            $table->integer("product_id")->unsigned();
            $table->string("path");
            $table->string("extension");

            $table->foreign("product_id")->references("id")->on("product");

            $table->timestamps();
        });

        Schema::table("product", function ($table) {
            $table->integer("primary_image")->unsigned()->nullable()->default(null);

            $table->foreign("primary_image")->references("id")->on("product_image");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("product", function ($table) {
            $table->dropColumn("primary_image");
        });

        Schema::drop("product_image");
    }
}
