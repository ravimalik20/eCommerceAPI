<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CollectionMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("collection", function ($table) {
            $table->increments("id");
            $table->string("name");
            $table->text("description");
            $table->enum('gender', ['male', 'female', 'unisex']);
            $table->timestamps();
        });

        Schema::create("collection_product", function ($table) {
            $table->increments("id");
            $table->integer("collection_id")->unsigned();
            $table->integer("product_id")->unsigned();

            $table->foreign("collection_id")->references("id")->on("collection");
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
        Schema::drop("collection");
        Schema::drop("collection_product");
    }
}
