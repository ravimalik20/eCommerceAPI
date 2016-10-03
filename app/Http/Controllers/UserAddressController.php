<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;
use App\Models\Address;

class UserAddressController extends Controller
{
    const DEFAULT_PER_PAGE = 10;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            $response = [
                "status" => "error",
                "messages" => ["User does not exist."]
            ];

            return $this->responseJson($response, 404);
        }

        $items_per_page = $request->input('per_page', self::DEFAULT_PER_PAGE);
        if (!is_numeric($items_per_page))
            $items_per_page = self::DEFAULT_PER_PAGE;

        $addresses = $user->addresses()->paginate($items_per_page);

        return $this->responseJson($addresses, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            $response = [
                "status" => "error",
                "messages" => ["User does not exist."]
            ];

            return $this->responseJson($response, 404);
        }

        $validation = Address::validate($request->all());
        if ($validation->fails()) {
            $response = [
                "status" => "error",
                "messages" => $validation->messages()->all()
            ];

            return $this->responseJson($response, 400);
        }

        $line1 = $request->input("line1");
        $line2 = $request->input("line2");
        $city = $request->input("city");
        $state_id = $request->input("state_id");
        $country_id = $request->input("country_id");
        $zipcode = $request->input("zipcode");
        $contact_name = $request->input("contact_name");
        $contact_number = $request->input("contact_number");

        $address = Address::make($user_id, $line1, $line2, $city, $state_id,
            $country_id, $zipcode, $contact_name, $contact_number);

        if ($address) {
            $response = [
                "status" => "success",
                "id" => $address->id
            ];

            return $this->responseJson($response, 200);
        }
        else {
            $response = [
                "status" => "error",
                "messages" => ["Error occured while saving address."]
            ];

            return $this->responseJson($response, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id, $id)
    {
        $user = User::find($user_id);
        if (!$user) {
            $response = [
                "status" => "error",
                "messages" => ["User does not exist."]
            ];

            return $this->responseJson($response, 404);
        }

        $address = Address::find($id);

        return $this->responseJson($address, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id, $id)
    {
        $user = User::find($user_id);
        if (!$user) {
            $response = [
                "status" => "error",
                "messages" => ["User does not exist."]
            ];

            return $this->responseJson($response, 404);
        }

        $validation = Address::validate($request->all());
        if ($validation->fails()) {
            $response = [
                "status" => "error",
                "messages" => $validation->messages()->all()
            ];

            return $this->responseJson($response, 400);
        }

        $line1 = $request->input("line1");
        $line2 = $request->input("line2");
        $city = $request->input("city");
        $state_id = $request->input("state_id");
        $country_id = $request->input("country_id");
        $zipcode = $request->input("zipcode");
        $contact_name = $request->input("contact_name");
        $contact_number = $request->input("contact_number");

        $address = Address::updateObj($id, $user_id, $line1, $line2, $city,
            $state_id, $country_id, $zipcode, $contact_name, $contact_number);

        if ($address) {
            $response = [
                "status" => "success",
                "id" => $address->id
            ];

            return $this->responseJson($response, 200);
        }
        else {
            $response = [
                "status" => "error",
                "messages" => ["Error occured while saving address."]
            ];

            return $this->responseJson($response, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id, $id)
    {
        $user = User::find($user_id);
        if (!$user) {
            $response = [
                "status" => "error",
                "messages" => ["User does not exist."]
            ];

            return $this->responseJson($response, 404);
        }

        $address = Address::find($id);
        if (!$address) {
            $response = [
                "status" => "error",
                "messages" => ["Address does not exist."]
            ];

            return $this->responseJson($response, 404);
        }

        $address->delete();

        $response = ["status" => "success"];

        return $this->responseJson($response, 200);
    }
}
