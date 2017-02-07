<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Validator;

class UserRole extends Model
{
    protected $table = "user_roles";

    protected $fillable = ["name"];

    protected $hidden = ["created_at", "updated_at"];

    public function users()
    {
        return $this->hasMany(\App\User::class, 'role_id', 'id');
    }
}
