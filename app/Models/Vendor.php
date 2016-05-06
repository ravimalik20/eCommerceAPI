<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Validator;

class Vendor extends Model
{
    protected $table = "vendor";

    protected $fillable = ["name"];

    protected $hidden = ["created_at", "updated_at"];

    public static function validate($inputs)
    {
        $rules = [
            "name" => "required|string"
        ];

        return Validator::make($inputs, $rules);
    }

    public static function make($name)
    {
        assert($name != null);

        $vendor = Vendor::create([
            "name" => $name
        ]);

        return $vendor;
    }

    public static function updateObj($id, $name)
    {
        assert($name != null);

        $vendor = Vendor::find($id);
        $vendor->name = $name;
        $vendor->save();

        return $vendor;
    }
}
