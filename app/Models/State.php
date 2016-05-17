<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Validator;

class State extends Model
{
    protected $table = "state";

    protected $fillable = ["name", "country_id"];

    protected $hidden = ["created_at", "updated_at"];
}
