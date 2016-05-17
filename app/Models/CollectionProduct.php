<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use \Validator;

class CollectionProduct extends Model
{
    protected $table = "collection_product";

    protected $fillable = ["collection_id", "product_id"];

    public static function validate($inputs)
    {
        $rules = [
            "product_id" => "required|integer|exists:product,id"
        ];

        return Validator::make($inputs, $rules);
    }

    public static function make($collection_id, $product_id)
    {
        $collection_product = CollectionProduct::firstOrCreate([
            "collection_id" => $collection_id,
            "product_id" => $product_id
        ]);

        return $collection_product;
    }
}
