<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $table = "manufacturer";

    protected $fillable = ["name"];
}
