<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Validator;

class Cart extends Model
{
    protected $table = "cart";

    protected $fillable = ["user_id", "status_id"];

    protected $hidden = ["created_at", "updated_at"];

    const ERR_MAKE = -1;

    public function products()
    {
        return $this->belongsToMany(Product::class, "cart_product")->withPivot("quantity");
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public static function validate($inputs)
    {
        $rules = [
            "user_id" => "integer|exists:users,id",
            "status_id" => "integer|exists:status,id"
        ];

        return Validator::make($inputs, $rules);
    }

    public static function make($user_id, $status)
    {
        $status = Status::where("name", $status)->first();

        $cart = Cart::create([
            "user_id" => $user_id,
            "status_id" => $status->id
        ]);

        if (!$cart)
            return self::ERR_MAKE;

        return $cart;
    }

    public static function updateObj($id, $status)
    {
        $status = Status::where("name", $status)->first();

        $cart = Cart::find($id);
        $cart->status_id = $status->id;
        $cart->save();

        return $cart;
    }
}
