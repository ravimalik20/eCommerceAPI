<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Validator;

class Color extends Model
{
    protected $table = "color";

    protected $fillable = ["name", "hexval"];

    protected $hidden = ["created_at", "updated_at"];

    public static function validate($inputs)
    {
        $rules = [
            "name" => "required|string",
            "hexval" => "required|regex:/^[0-9A-Fa-f]{6}$/"
        ];

        return Validator::make($inputs, $rules);
    }

    public static function make($name, $hexval)
    {
        assert($name != null);
        assert($hexval != null);

        $color = Color::create([
            "name" => $name,
            "hexval" => $hexval
        ]);

        return $color;
    }

    public static function updateObj($id, $name, $hexval)
    {
        assert($name != null);
        assert($hexval != null);

        $color = Color::find($id);
        $color->name = $name;
        $color->hexval = $hexval;
        $color->save();

        return $color;
    }
}
