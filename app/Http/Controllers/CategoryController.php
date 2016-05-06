<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return $categories->toJson();
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
        $validation = Category::validate($request->all());
        if ($validation->fails()) {
            $response = [
                "status" => "error",
                "messages" => $validation->messages()->all()
            ];

            return json_encode($response);
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
        $category = Category::findOrFail($id);

        return $category->toJson();
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
        $validation = Category::validate($request->all(), true);
        if ($validation->fails()) {
            $response = [
                "status" => "error",
                "messages" => $validation->messages()->all()
            ];

            return response()->json($response);
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
        $category = Category::find($id);

        if (!$category)
            return abort(404);

        $category->delete();

        $response = ["status" => "success"];

        return response()->json($response);
    }
}
