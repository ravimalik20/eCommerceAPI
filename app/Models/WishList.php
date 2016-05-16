<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Validator;

class WishList extends Model
{
    protected $table = "wish_list";

    protected $fillable = ["user_id", "product_id"];

    protected $hidden = ["created_at", "updated_at"];

    public static function validate($inputs)
    {
        $rules = [
            "product_id" => "required|integer|exists:product,id"
        ];

        return Validator::make($inputs, $rules);
    }

    public static function make($user_id, $product_id)
    {
        assert($user_id != null);
        assert($product_id != null);

        $wish_list_entry = WishList::firstOrCreate([
            "user_id" => $user_id,
            "product_id" => $product_id
        ]);

        return $wish_list_entry;
    }
}
