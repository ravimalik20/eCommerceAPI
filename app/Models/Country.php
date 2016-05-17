<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Validator;

class Country extends Model
{
    protected $table = "country";

    protected $fillable = ["name"];

    protected $hidden = ["created_at", "updated_at"];
}
