<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\ProductImage;
use App\Models\Product;

class ProductImageController extends Controller
{
    const DEFAULT_PER_PAGE = 10;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $product_id)
    {
        $product = Product::find($product_id);
        if (!$product) {
            $response = [
                "status" => "error",
                "messages" => ["Product does not exist."]
            ];

            return $this->responseJson($response, 400);
        }

        $items_per_page = $request->input('per_page', self::DEFAULT_PER_PAGE);
        if (!is_numeric($items_per_page))
            $items_per_page = self::DEFAULT_PER_PAGE;

        $images = $product->images()->paginate($items_per_page);

        return $this->responseJson($images, 200);
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
    public function store(Request $request, $product_id)
    {
        $product = Product::find($product_id);
        if (!$product) {
            $response = [
                "status" => "error",
                "messages" => ["Product does not exist."]
            ];

            return $this->responseJson($response, 400);
        }

        $validation = ProductImage::validate($request->all());
        if ($validation->fails()) {
            $response = [
                "status" => "error",
                "messages" => $validation->messages()->all()
            ];

            return $this->responseJson($response, 400);
        }

        $image_request = $request->file('image');

        $image = ProductImage::make($product_id, $image_request);

        if ($image) {
            $response = [
                "status" => "success",
                "id" => $image->id
            ];

            return $this->responseJson($response, 200);
        }
        else {
            $response = [
                "status" => "error",
                "messages" => ["Some error occured while saving the data."]
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
    public function show($product_id, $id)
    {
        $product = Product::find($product_id);
        if (!$product) {
            $response = [
                "status" => "error",
                "messages" => ["Product does not exist."]
            ];

            return $this->responseJson($response, 400);
        }

        $image = ProductImage::getObj($product_id, $id);

        if (!$image) {
            $response = [
                "status" => "error",
                "messages" => "No such image exists."
            ];

            return $this->responseJson($response, 404);
        }

        return $this->responseJson($image, 200);
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
    public function destroy($product_id, $id)
    {
        $product = Product::find($product_id);
        if (!$product) {
            $response = [
                "status" => "error",
                "messages" => ["Product does not exist."]
            ];

            return $this->responseJson($response, 400);
        }

        $product_image = ProductImage::find($id);
        if ($product_image) {
            $product_image->delete();

            $response = [
                "status" => "success"
            ];

            return $this->responseJson($response, 200);
        }
        else {
            $response = [
                "status" => "error",
                "messages" => ["Error occured while saving data."]
            ];

            return $this->responseJson($response, 500);
        }
    }
}
