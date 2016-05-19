<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\Product;
use App\Models\Address;
use App\Models\Cart;

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

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class)->with('status');
    }
}
