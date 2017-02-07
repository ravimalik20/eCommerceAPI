<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;

use App\Models\Category;

class CategoryController extends Controller
{
    const DEFAULT_PER_PAGE = 10;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', \App\Models\Category::class);

        $items_per_page = $request->input('per_page', self::DEFAULT_PER_PAGE);
        if (!is_numeric($items_per_page))
            $items_per_page = self::DEFAULT_PER_PAGE;

        $categories = Category::paginate($items_per_page);

        return $this->responseJson($categories, 200);
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
        $this->authorize('create', Category::class);

        $validation = Category::validate($request->all());
        if ($validation->fails()) {
            $response = [
                "status" => "error",
                "messages" => $validation->messages()->all()
            ];

            return $this->responseJson($response, 400);
        }

        $parent = $request->input('parent', null);
        $category = Category::make($request->input("name"), $parent);

        if ($category) {
            $response = [
                "status" => "success",
                "id" => $category->id
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
    public function show($id)
    {
        $category = Category::findOrFail($id);
        $this->authorize('view', $category);

        return $this->responseJson($category, 200);
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
        $category = Category::findOrFail($id);
        $this->authorize('update', $category);

        $validation = Category::validate($request->all(), true);
        if ($validation->fails()) {
            $response = [
                "status" => "error",
                "messages" => $validation->messages()->all()
            ];

            return $this->responseJson($response, 400);
        }

        $name = $request->input("name");
        $category = Category::updateObj($id, $name);

        if ($category) {
            $response = [
                "status" => "success",
                "id" => $category->id
            ];
        }
        else {
            $response = [
                "status" => "error",
                "messages" => ["Some error occured while saving the data"]
            ];

            return $this->responseJson($response, 400);
        }

        return $this->responseJson($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $this->authorize('delete', $category);

        if (!$category)
            return abort(404);

        $category->delete();

        $response = ["status" => "success"];

        return $this->responseJson($response, 200);
    }
}
