<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Validator;

class Manufacturer extends Model
{
    protected $table = "manufacturer";

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

        $manufacturer = Manufacturer::create([
            "name" => $name
        ]);

        return $manufacturer;
    }

    public static function updateObj($id, $name)
    {
        assert($name != null);

        $manufacturer = Manufacturer::find($id);
        $manufacturer->name = $name;
        $manufacturer->save();

        return $manufacturer;
    }
}
