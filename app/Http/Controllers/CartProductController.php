<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use App\User;

class CartProductController extends Controller
{
    const DEFAULT_PER_PAGE = 10;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $user_id, $cart_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            $response = [
                "status" => "error",
                "messages" => ["User doees not exist."]
            ];

            return $this->responseJson($response, 404);
        }

        $cart = Cart::find($cart_id);
        if (!$cart) {
            $response = [
                "status" => "error",
                "messages" => ["Cart doees not exist."]
            ];

            return $this->responseJson($response, 404);
        }

        $items_per_page = $request->input('per_page', self::DEFAULT_PER_PAGE);
        if (!is_numeric($items_per_page))
            $items_per_page = self::DEFAULT_PER_PAGE;

        $products = $cart->products()->paginate($items_per_page);

        return $this->responseJson($products, 200);
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
    public function store(Request $request, $user_id, $cart_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            $response = [
                "status" => "error",
                "messages" => ["User doees not exist."]
            ];

            return $this->responseJson($response, 404);
        }

        $cart = Cart::find($cart_id);
        if (!$cart) {
            $response = [
                "status" => "error",
                "messages" => ["Cart doees not exist."]
            ];

            return $this->responseJson($response, 404);
        }

        $validation = CartProduct::validate($request->all());
        if ($validation->fails()) {
            $response = [
                "status" => "error",
                "messages" => $validation->messages()->all()
            ];

            return $this->responseJson($response, 400);
        }

        $product_id = $request->input("product_id");
        $quantity = $request->input("quantity");

        $cart_product = CartProduct::make($cart_id, $product_id, $quantity);

        if ($cart_product) {
            $response = [
                "status" => "success"
            ];

            return $this->responseJson($response, 200);
        }
        else {
            $response = [
                "status" => "error",
                "messages" => ["Some error occured while saving."]
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
    public function show($user_id, $cart_id, $id)
    {
        $user = User::find($user_id);
        if (!$user) {
            $response = [
                "status" => "error",
                "messages" => ["User doees not exist."]
            ];

            return $this->responseJson($response, 404);
        }

        $cart = Cart::find($cart_id);
        if (!$cart) {
            $response = [
                "status" => "error",
                "messages" => ["Cart doees not exist."]
            ];

            return $this->responseJson($response, 404);
        }

        $cart_product = CartProduct::where("cart_id", $cart_id)
            ->where("product_id", $id)
            ->first();

        if (!$cart_product) {
            $response = [
                "status" => "error",
                "messages" => ["Product does not exist in the cart."]
            ];

            return $this->responseJson($response, 404);
        }

        $product = Product::join("cart_product", "cart_product.product_id", '=', 'product.id')
            ->where("cart_product.cart_id", $cart->id)
            ->first();

        return $this->responseJson($product, 200);
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
    public function update(Request $request, $user_id, $cart_id, $id)
    {
        $user = User::find($user_id);
        if (!$user) {
            $response = [
                "status" => "error",
                "messages" => ["User doees not exist."]
            ];

            return $this->responseJson($response, 404);
        }

        $cart = Cart::find($cart_id);
        if (!$cart) {
            $response = [
                "status" => "error",
                "messages" => ["Cart doees not exist."]
            ];

            return $this->responseJson($response, 404);
        }

        $validation = CartProduct::validate($request->all());
        if ($validation->fails()) {
            $response = [
                "status" => "error",
                "messages" => $validation->messages()->all()
            ];

            return $this->responseJson($response, 400);
        }

        $quantity = $request->input("quantity");

        $cart_product = CartProduct::where("cart_id", $cart_id)
            ->where("product_id", $id)
            ->first();

        if (!$cart_product) {
            $cart_product = CartProduct::make($cart_id, $id, $quantity);
        }
        else {
            $cart_product = CartProduct::updateObj($cart_id, $id, $quantity);
        }

        if ($cart_product) {
            $response = [
                "status" => "success"
            ];

            return $this->responseJson($response, 200);
        }
        else {
            $response = [
                "status" => "error",
                "messages" => ["Some error occured while saving."]
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
    public function destroy($user_id, $cart_id, $id)
    {
        $user = User::find($user_id);
        if (!$user) {
            $response = [
                "status" => "error",
                "messages" => ["User doees not exist."]
            ];

            return $this->responseJson($response, 404);
        }

        $cart = Cart::find($cart_id);
        if (!$cart) {
            $response = [
                "status" => "error",
                "messages" => ["Cart doees not exist."]
            ];

            return $this->responseJson($response, 404);
        }

        $cart_product = CartProduct::where("cart_id", $cart_id)
            ->where("product_id", $id)
            ->first();

        if (!$cart_product) {
            $response = [
                "status" => "error",
                "messages" => ["Product does not exist in the cart."]
            ];

            return $this->responseJson($response, 404);
        }

        $cart_product->delete();

        $response = [
            "status" => "success",
        ];

        return $this->responseJson($response, 200);
    }
}
