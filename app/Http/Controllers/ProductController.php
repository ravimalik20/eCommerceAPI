<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::getAll();

        return $products->toJson();
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
    public function store(Request $request)
    {
        $validation = Product::validate($request->all());

        if ($validation->fails()) {
            $response = [
                "status" => "error",
                "messages" => $validation->messages()->all()
            ];

            return response()->json($response);
        }

        $name = $request->input("name");
        $description = $request->input("description");
        $vendor = $request->input("vendor");
        $manufacturer = $request->input("manufacturer");
        $category = $request->input("category");
        $frozen = $request->input("frozen");
        $color = $request->input("color");
        $size = $request->input("size");

        $product = Product::make($name, $description, $vendor, $manufacturer,
            $category, $frozen, $color, $size);

        if ($product) {
            $response = [
                "status" => "success",
                "id" => $product->id
            ];
        }
        else {
            $response = [
                "status" => "error",
                "messages" => ["Error occured in saving product."]
            ];
        }

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::getObj($id);

        if (!$product) {
            return abort(404);
        }
        else {
            return $product->toJson();
        }
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
    public function update(Request $request, $id)
    {
        $validation = Product::validate($request->all());

        if ($validation->fails()) {
            $response = [
                "status" => "error",
                "messages" => $validation->messages()->all()
            ];

            return response()->json($response);
        }

        $name = $request->input("name");
        $description = $request->input("description");
        $vendor = $request->input("vendor");
        $manufacturer = $request->input("manufacturer");
        $category = $request->input("category");
        $frozen = $request->input("frozen");
        $color = $request->input("color");
        $size = $request->input("size");

        $product = Product::updateObj($id, $name, $description, $vendor, $manufacturer,
            $category, $frozen, $color, $size);

        if ($product) {
            $response = [
                "status" => "success",
                "id" => $product->id
            ];
        }
        else {
            $response = [
                "status" => "error",
                "messages" => ["Error occured in saving product."]
            ];
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();

            $response = [
                "status" => "success"
            ];
        }
        else {
            $response = [
                "status" => "error",
                "messages" => ["Product does not exist."]
            ];
        }

        return response()->json($response);
    }
}