<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Category;
use App\Models\CategoryProduct;

class CategoryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($category_id)
    {
        $category = Category::find($category_id);

        if (!$category) {
            $response = [
                "status" => "error",
                "messages" => ["Category does not exist."]
            ];

            return $this->responseJson($response, 400);
        }

        $products = $category->products;

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
    public function store(Request $request, $category_id)
    {
        $category = Category::find($category_id);

        if (!$category) {
            $response = [
                "status" => "error",
                "messages" => ["Category does not exist."]
            ];

            return $this->responseJson($response, 400);
        }

        $validation = CategoryProduct::validate($request->all());
        if ($validation->fails()) {
            $response = [
                "status" => "error",
                "messages" => $validation->messages()->all()
            ];

            return $this->responseJson($response, 400);
        }

        $product_id = $request->input("product_id");

        $category_product = CategoryProduct::make($category_id, $product_id);

        if ($category_product) {
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
    public function destroy($category_id, $id)
    {
        $category = Category::find($category_id);

        if (!$category) {
            $response = [
                "status" => "error",
                "messages" => ["Category does not exist."]
            ];

            return $this->responseJson($response, 400);
        }

        $category_product = CategoryProduct::where("category_id", $category_id)
            ->where("product_id", $id)
            ->first();

        if (!$category_product) {
            $response = [
                "status" => "error",
                "messages" => ["Product does not exist in this category."]
            ];

            return $this->responseJson($response, 400);
        }

        $category_product->delete();

        $response = [
            "status" => "success",
        ];

        return $this->responseJson($response, 200);
    }
}
