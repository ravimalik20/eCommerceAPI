<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use \Validator;

class CartProduct extends Model
{
    protected $table = "cart_product";

    protected $fillable = ["cart_id", "product_id", "quantity"];

    public static function validate($inputs)
    {
        $rules = [
            "product_id" => "required|integer|exists:product,id",
            "quantity" => "required|integer"
        ];

        return Validator::make($inputs, $rules);
    }

    public static function make($cart_id, $product_id, $quantity)
    {
        $cart_product = CartProduct::firstOrCreate([
            "cart_id" => $cart_id,
            "product_id" => $product_id,
            "quantity" => $quantity
        ]);

        return $cart_product;
    }

    public static function updateObj($cart_id, $product_id, $quantity)
    {
        $cart_product = CartProduct::where("cart_id", $cart_id)
            ->where("product_id", $product_id)
            ->first();

        $cart_product->cart_id = $cart_id;
        $cart_product->product_id = $product_id;
        $cart_product->quantity = $quantity;

        $cart_product->save();

        return $cart_product;
    }
}
