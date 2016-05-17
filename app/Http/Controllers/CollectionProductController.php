<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Collection;
use App\Models\CollectionProduct;

class CollectionProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($collection_id)
    {
        $collection = Collection::find($collection_id);

        if (!$collection) {
            $response = [
                "status" => "error",
                "messages" => ["Collection does not exist."]
            ];

            return $this->responseJson($response, 400);
        }

        $products = $collection->products;

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
    public function store(Request $request, $collection_id)
    {
        $collection = Collection::find($collection_id);

        if (!$collection) {
            $response = [
                "status" => "error",
                "messages" => ["Collection does not exist."]
            ];

            return $this->responseJson($response, 400);
        }

        $validation = CollectionProduct::validate($request->all());
        if ($validation->fails()) {
            $response = [
                "status" => "error",
                "messages" => $validation->messages()->all()
            ];

            return $this->responseJson($response, 400);
        }

        $product_id = $request->input("product_id");

        $collection_product = CollectionProduct::make($collection_id, $product_id);

        if ($collection_product) {
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
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($collection_id, $id)
    {
        $collection = Collection::find($collection_id);

        if (!$collection) {
            $response = [
                "status" => "error",
                "messages" => ["Collection does not exist."]
            ];

            return $this->responseJson($response, 400);
        }

        $collection_product = CollectionProduct::where("collection_id", $collection_id)
            ->where("product_id", $id)
            ->first();

        if (!$collection_product) {
            $response = [
                "status" => "error",
                "messages" => ["Product does not exist in this collection."]
            ];

            return $this->responseJson($response, 400);
        }

        $collection_product->delete();

        $response = [
            "status" => "success",
        ];

        return $this->responseJson($response, 200);
    }
}
