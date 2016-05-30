<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Validator;
use \Storage;

class ProductImage extends Model
{
    protected $table = "product_image";

    protected $fillable = ["product_id", "path", "extension"];

    protected $hidden = ["created_at", "updated_at"];

    public static function validate($inputs)
    {
        $rules = [
            "image" => "required|mimes:jpg,jpeg,png,bmp"
        ];

        return Validator($inputs, $rules);
    }

    public static function make($product_id, $image)
    {
        $image_extension = $image->getClientOriginalExtension();
        $image_path = str_random(10).$image->getClientOriginalName();

        $image_content = file_get_contents($image->getRealPath());

        Storage::put($image_path, $image_content);

        $image_obj = ProductImage::create([
            "product_id" => $product_id,
            "path" => $image_path,
            "extension" => $image_extension
        ]);

        return $image_obj;
    }
}
