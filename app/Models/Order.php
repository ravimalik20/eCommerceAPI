<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "order";

    protected $fillable = ["user_id", "discount", "delivery_till"];
}
