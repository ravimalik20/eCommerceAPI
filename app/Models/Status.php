<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Validator;

class Status extends Model
{
    protected $table = "status";

    protected $fillable = ["name"];

    protected $hidden = ["created_at", "updated_at"];
}
