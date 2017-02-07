<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use \Input;

use App\Models\Color;

class ColorController extends Controller
{
    const DEFAULT_PER_PAGE = 10;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', Color::class);

        $items_per_page = $request->input('per_page', self::DEFAULT_PER_PAGE);
        if (!is_numeric($items_per_page))
            $items_per_page = self::DEFAULT_PER_PAGE;

        $colors = Color::paginate($items_per_page);

        return $this->responseJson($colors, 200);
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
        $this->authorize('create', Color::class);

        $validation = Color::validate($request->all());
        if ($validation->fails()) {
            $response = [
                "status" => "error",
                "messages" => $validation->messages()->all()
            ];

            return $this->responseJson($response, 400);
        }

        $name = $request->input('name', null);
        $hexval = $request->input('hexval', null);

        $color = Color::make($name, $hexval);

        if ($color) {
            $response = [
                "status" => "success",
                "id" => $color->id
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
        $color = Color::findOrFail($id);

        $this->authorize('view', $color);

        return $this->responseJson($color, 200);
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
        $color = Color::findOrFail($id);
        $this->authorize('update', $color);

        $validation = Color::validate($request->all());
        if ($validation->fails()) {
            $response = [
                "status" => "error",
                "messages" => $validation->messages()->all()
            ];

            return $this->responseJson($response, 400);
        }

        $name = $request->input('name', null);
        $hexval = $request->input('hexval', null);

        $color = Color::updateObj($id, $name, $hexval);

        if ($color) {
            $response = [
                "status" => "success",
                "id" => $color->id
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
    public function destroy($id)
    {
        $color = Color::findOrFail();
        $this->authorize('delete', $color);

        $color = Color::find($id);

        if (!$color)
            return abort(404);

        $color->delete();

        $response = ["status" => "success"];

        return $this->responseJson($response, 200);
    }
}
