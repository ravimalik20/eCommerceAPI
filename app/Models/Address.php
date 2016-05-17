<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Validator;

class Address extends Model
{
    protected $table = "user_address";

    protected $fillable = ["user_id", "line1", "line2", "city", "state_id",
        "country_id", "zipcode", "contact_name", "contact_number"];

    protected $hidden = ["created_at", "updated_at"];

    public static function validate($inputs)
    {
        $rules = [
            "user_id" => "required|integer|exists:users,id",
            "line1" => "required|string",
            "line2" => "string",
            "city" => "required|string",
            "state_id" => "required|integer|exists:state,id",
            "country_id" => "required|integer|exists:country,id",
            "zipcode" => "required|digits:6",
            "contact_name" => "required|string",
            "contact_number" => "required|digits:10"
        ];

        return Validator::make($inputs, $rules);
    }

    public static function make($user_id, $line1, $line2, $city, $state_id,
        $country_id, $zipcode, $contact_name, $contact_number)
    {
        $address = Address::create([
            "user_id" => $user_id,
            "line1" => $line1,
            "line2" => empty($line2) ? "" : $line2,
            "city" => $city,
            "state_id" => $state_id,
            "country_id" => $country_id,
            "zipcode" => $zipcode,
            "contact_name" => $contact_name,
            "contact_number" => $contact_number
        ]);

        return $address;
    }

    public static function updateObj($id, $user_id, $line1, $line2, $city,
        $state_id, $country_id, $zipcode, $contact_name, $contact_number)
    {
        $address = Address::find($id);

        $address->user_id = $user_id;
        $address->line1 = $line1;
        $address->line2 = empty($line2) ? "" : $line2;
        $address->city = $city;
        $address->state_id = $state_id;
        $address->country_id = $country_id;
        $address->zipcode = $zipcode;
        $address->contact_name = $contact_name;
        $address->contact_number = $contact_number;

        $address->save();

        return $address;
    }
}
