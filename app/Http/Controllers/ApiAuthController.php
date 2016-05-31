<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Http\Requests;

use App\User;

class ApiAuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $validation = $this->validator($request->all());
        if ($validation->fails()) {
            $response = [
                "status" => "error",
                "messages" => $validation->messages()->all()
            ];

            return $this->responseJson($response, 400);
        }

        $email = $request->input('email');
        $password = $request->input('password');

        $user = Auth::attempt(['email' => $email, 'password' => $password]);

        if (!$user) {
            $response = [
                "status" => "error",
                "messages" => "Invalid login credentials"
            ];

            return $this->responseJson($response, 400);
        }

        $user = User::where("email", $request->input('email'))->first();
        $token = $user->updateToken();

        $response = [
            "status" => "success",
            "token" => $token
        ];

        return $this->responseJson($response, 200);
    }

    private function validator($inputs)
    {
        $rules = [
            "email" => "required|email|exists:users,email",
            "password" => "required|string"
        ];

        return Validator::make($inputs, $rules);
    }
}
