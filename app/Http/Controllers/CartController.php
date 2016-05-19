<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;

use App\Models\Cart;
use App\User;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            $response = [
                "status" => "error",
                "messages" => ["User does not exist."]
            ];

            return $this->responseJson($response, 404);
        }

        $carts = $user->carts;

        return $this->responseJson($carts, 200);
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

        $validation = Cart::validate($request->all());
        if ($validation->fails()) {
            $response = [
                "status" => "error",
                "messages" => $validation->messages()->all()
            ];

            return $this->responseJson($response, 400);
        }

        $status = $request->input('status', 'created');

        $cart = Cart::make($user_id, $status);

        if ($cart) {
            $response = [
                "status" => "success",
                "id" => $cart->id
            ];
        }
        else {
            $response = [
                "status" => "error",
                "messages" => ["Some error occured while saving the data"]
            ];

            return $this->responseJson($response, 500);
        }

        return $this->responseJson($response, 200);
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

        $cart = Cart::with('status')->find($id);
        if (!$cart) {
            $response = [
                "status" => "error",
                "messages" => ["Cart does not exist."]
            ];

            return $this->responseJson($response, 404);
        }

        return $this->responseJson($cart, 200);
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

        $validation = Cart::validate($request->all());
        if ($validation->fails()) {
            $response = [
                "status" => "error",
                "messages" => $validation->messages()->all()
            ];

            return $this->responseJson($response, 400);
        }

        $cart = Cart::find($id);
        if (!$cart) {
            $response = [
                "status" => "error",
                "messages" => ["Cart does not exist."]
            ];

            return $this->responseJson($response, 404);
        }

        $status = $request->input('status', 'created');

        $cart = Cart::updateObj($id, $status);

        if ($cart) {
            $response = [
                "status" => "success",
                "id" => $cart->id
            ];
        }
        else {
            $response = [
                "status" => "error",
                "messages" => ["Some error occured while saving the data"]
            ];

            return $this->responseJson($response, 500);
        }

        return $this->responseJson($response, 200);
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

        $cart = Cart::find($id);
        if (!$cart) {
            $response = [
                "status" => "error",
                "messages" => ["Cart does not exist."]
            ];

            return $this->responseJson($response, 404);
        }

        $cart->delete();

        $response = ["status" => "success"];

        return $this->responseJson($response, 200);
    }
}
