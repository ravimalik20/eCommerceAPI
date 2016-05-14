<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Validator;

class Order extends Model
{
    protected $table = "order";

    protected $fillable = ["user_id", "discount", "delivery_till"];

    protected $hidden = ["updated_at"];

    const ERR_MAKE_ORDER = -1;
    const ERR_MAKE_NO_PRODUCTS = -2;

    public function products()
    {
        return $this->belongsToMany(Product::class, "order_product");
    }

    public static function validate($inputs)
    {
        $rules = [
            "user_id" => "required|integer|exists:users,id",
            "discount" => "numeric",
            "delivery_till" => "required|date_format:Y-m-d h:i:s",
            "products.*" => "required|integer"
        ];

        return Validator::make($inputs, $rules);
    }

    public static function make($user_id, $discount, $delivery_till, $products)
    {
        $order = Order::create([
            "user_id" => $user_id,
            "discount" => empty($discount) ? 0 : $discount,
            "delivery_till" => $delivery_till,
        ]);

        if (!$order)
            return self::ERR_MAKE_ORDER;

        if (count($products) <= 0)
            return self::ERR_MAKE_NO_PRODUCTS;

        $data = [];

        foreach ($products as $id) {
            array_push($data, ["order_id" => $order->id, "product_id" => $id]);
        }

        OrderProduct::insert($data);

        return $order;
    }
}
