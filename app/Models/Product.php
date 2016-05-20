<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Validator;

class Product extends Model
{
    protected $table = "product";

    protected $fillable = ["base_product_id", "color_id", "size", "frozen",
        "gender"];

    public static function validate($inputs)
    {
        $rules = [
            "name" => "required|string",
            "description" => "string",
            "vendor" => "required|integer|exists:vendor,id",
            "manufacturer" => "required|integer|exists:manufacturer,id",
            "category" => "required|integer|exists:category,id",
            "frozen" => "boolean",
            "color" => "string|regex:/^[0-9a-fA-F]{6}$/",
            "size" => "string",
            "gender" => "in:male,female,unisex"
        ];

        return Validator::make($inputs, $rules);
    }

    public static function make($name, $description, $vendor, $manufacturer,
        $category, $frozen, $color, $size, $gender="unisex", $id=null)
    {
        $base_product = BaseProduct::create([
            "name" => $name,
            "description" => empty($description) ? "" : $description,
            "vendor_id" => $vendor,
            "manufacturer_id" => $manufacturer,
            "category_id" => $category,
            "frozen" => empty($frozen) ? false : $frozen
        ]);

        if (!empty($color))
            $colorObj = Color::firstOrCreate(['hexval' => $color]);

        $product = Product::create([
            "base_product_id" => $base_product->id,
            "color_id" => isset($colorObj) ? $colorObj->id : null,
            "size" => empty($size) ? "" : $size,
            "frozen" => empty($frozen) ? false : $frozen,
            "gender" => empty($gender) ? "unisex" : $gender
        ]);

        return $product;
    }

    public static function updateObj($id, $name, $description, $vendor, $manufacturer,
        $category, $frozen, $color, $size, $gender)
    {
        $product = Product::find($id);

        $base_product = BaseProduct::find($product->base_product_id);

        $base_product->name = $name;
        $base_product->description = empty($description) ? "" : $description;
        $base_product->vendor_id = $vendor;
        $base_product->manufacturer_id = $manufacturer;
        $base_product->category_id = $category;
        $base_product->frozen = empty($frozen) ? false : $frozen;

        $base_product->save();

        if (!empty($color))
            $colorObj = Color::firstOrCreate(['hexval' => $color]);

        $product->base_product_id = $base_product->id;
        $product->color_id = isset($colorObj) ? $colorObj->id : null;
        $product->size = empty($size) ? "" : $size;
        $product->frozen = empty($frozen) ? false : $frozen;
        $product->gender = empty($gender) ? "unisex" : $gender;

        $product->save();

        return $product;
    }

    public static function getAll($items_per_page=10)
    {
        $products = Product::join("base_product", "base_product.id", "=", "product.id")
            ->paginate($items_per_page);

        return $products;
    }

    public static function getObj($id)
    {
        $product = Product::join("base_product", "base_product.id", "=", "product.id")
            ->where("product.id", $id)
            ->first();

        return $product;
    }
}
