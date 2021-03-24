<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends Controller {

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
                    'email' => 'required',
                    'password' => 'required',
        ]);
        if ($validator->fails()) {
            return Helper::fail($validator->errors()->first(), []);
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $user->token = Auth::user()->createToken('MyApp')->accessToken;
            return Helper::success("Login success", $user);
        } else {
            return Helper::fail("Authentication fail", []);
        }
    }

}
