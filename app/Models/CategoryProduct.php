<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use \Validator;

class CategoryProduct extends Model
{
    protected $table = "category_product";

    protected $fillable = ["category_id", "product_id"];

    public static function validate($inputs)
    {
        $rules = [
            "product_id" => "required|integer|exists:product,id"
        ];

        return Validator::make($inputs, $rules);
    }

    public static function make($category_id, $product_id)
    {
        $category_product = CategoryProduct::firstOrCreate([
            "category_id" => $category_id,
            "product_id" => $product_id
        ]);

        return $category_product;
    }
}
