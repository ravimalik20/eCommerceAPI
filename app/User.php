<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\Product;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function wishList()
    {
        return $this->belongsToMany(Product::class, 'wish_list');
    }
}
