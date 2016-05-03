<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseProduct extends Model
{
    protected $table = "base_product";

    protected $fillable = ["name", "description", "vendor_id", "manufacturer_id",
        "category_id", "frozen"];
}
