<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;
use Hash;

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
        'name', 'email', 'password', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function validate($inputs)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed'
        ];

        return Validator::make($inputs, $rules);
    }

    public static function make($name, $email, $password)
    {
        $user = User::create([
            "name" => $name,
            "email" => $email,
            "password" => Hash::make($password),
            "api_token" => str_random(60)
        ]);

        return $user;
    }

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
