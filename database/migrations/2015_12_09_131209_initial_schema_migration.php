<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialSchemaMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("category", function ($table)
        {
            $table->increments("id");
            $table->string("name");
            $table->integer("parent")->unsigned()->nullable()->default(null);
            $table->timestamps();
        });

        Schema::table("category", function ($table)
        {
            $table->foreign("parent")->references("id")->on("category");
        });

        Schema::create("manufacturer", function ($table)
        {
            $table->increments("id");
            $table->string("name");
            $table->timestamps();
        });

        Schema::create("vendor", function ($table)
        {
            $table->increments("id");
            $table->string("name");
            $table->timestamps();
        });

        Schema::create("color", function ($table)
        {
            $table->increments("id");
            $table->string("name");
            $table->string("hexval");
            $table->timestamps();
        });

        Schema::create("base_product", function ($table)
        {
            $table->increments("id");
            $table->string("name");
            $table->text("description");
            $table->integer("vendor_id")->unsigned();
            $table->foreign("vendor_id")->references("id")->on("vendor");
            $table->integer("manufacturer_id")->unsigned();
            $table->foreign("manufacturer_id")->references("id")->on("manufacturer");
            $table->integer("category_id")->unsigned();
            $table->foreign("category_id")->references("id")->on("category");
            $table->boolean("frozen");
            $table->timestamps();
        });

        Schema::create("product", function ($table)
        {
            $table->increments("id");
            $table->integer("base_product_id")->unsigned();
            $table->foreign("base_product_id")->references("id")->on("base_product");
            $table->integer("color_id")->unsigned();
            $table->foreign("color_id")->references("id")->on("color");
            $table->string("size");
            $table->boolean("frozen");
            $table->timestamps();
        });

        Schema::create("order", function ($table)
        {
            $table->increments("id");
            $table->integer("user_id")->unsigned();
            $table->foreign("user_id")->references("id")->on("users");
            $table->float("discount");
            $table->datetime("delivery_till");
            $table->timestamps();
        });

        Schema::create("order_product", function ($table)
        {
            $table->increments("id");
            $table->integer("order_id");
            $table->integer("product_id");
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
        Schema::drop("order_products");
        Schema::drop("order");
        Schema::drop("product");
        Schema::drop("base_product");
        Schema::drop("color");
        Schema::drop("vendor");
        Schema::drop("manufacturer");
        Schema::drop("category");
    }
}
