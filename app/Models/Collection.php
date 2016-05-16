<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Validator;

class Collection extends Model
{
    protected $table = "collection";

    protected $fillable = ["name", "description", "gender"];

    public static function validate($inputs, $show=false)
    {
        $rules = [
            "name" => "required|string",
            "description" => "string",
            "gender" => "required|in:male,female,unisex"
        ];

        return Validator::make($inputs, $rules);
    }

    public static function make($name, $description, $gender)
    {
        $collection = Collection::create([
            "name" => $name,
            "description" => empty($description) ? "" : $description,
            "gender" => $gender
        ]);

        return $collection;
    }

    public static function updateObj($id, $name, $description, $gender)
    {
        $collection = Collection::find($id);
        $collection->name = $name;
        $collection->description = empty($description) ? "" : $description;
        $collection->gender = $gender;
        $collection->save();

        return $collection;
    }
}
