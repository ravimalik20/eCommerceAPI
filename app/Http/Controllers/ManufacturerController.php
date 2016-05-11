<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Manufacturer;

class ManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manufacturers = Manufacturer::all();

        return $manufacturers->toJson();
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
        $validation = Manufacturer::validate($request->all());
        if ($validation->fails()) {
            $response = [
                "status" => "error",
                "messages" => $validation->messages()->all()
            ];

            return response()->json($response);
        }

        $name = $request->input('name', null);

        $manufacturer = Manufacturer::make($name);

        if ($manufacturer) {
            $response = [
                "status" => "success",
                "id" => $manufacturer->id
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
        $manufacturer = Manufacturer::findOrFail($id);

        return $manufacturer->toJson();
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
        $validation = Manufacturer::validate($request->all());
        if ($validation->fails()) {
            $response = [
                "status" => "error",
                "messages" => $validation->messages()->all()
            ];

            return response()->json($response);
        }

        $name = $request->input('name', null);

        $manufacturer = Manufacturer::updateObj($id, $name);

        if ($manufacturer) {
            $response = [
                "status" => "success",
                "id" => $manufacturer->id
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
        $manufacturer = Manufacturer::find($id);

        if (!$manufacturer)
            return abort(404);

        $manufacturer->delete();

        $response = ["status" => "success"];

        return response()->json($response);
    }
}
