<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Validator;

class BaseProduct extends Model
{
    protected $table = "base_product";

    protected $fillable = ["name", "description", "vendor_id", "manufacturer_id",
        "category_id", "frozen"];

    public function addProduct($id, $color, $size, $frozen)
    {
        $base_product = BaseProduct::find($id);

        if (!empty($color))
            $colorObj = Color::firstOrCreate(['hexval' => $color]);

        $product = Product::create([
            "base_product_id" => $base_product->id,
            "color_id" => isset($colorObj) ? $colorObj->id : null,
            "size" => empty($size) ? "" : $size,
            "frozen" => empty($frozen) ? false : $frozen,
        ]);

        return $product;
    }
}
