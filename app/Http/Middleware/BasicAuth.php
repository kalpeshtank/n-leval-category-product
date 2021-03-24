<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BasicAuth {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $header = array("api-key" => $request->header('api-key'));
//        dd($header);
        $validator = Validator::make($header, ['api-key' => 'required',]);
        if ($validator->fails()) {
            $response = [
                'status' => false,
                'code' => 500,
                'msg' => $validator->errors()->first(),
                'version' => env('VERSION', "1.0.0"),
                'data' => []
            ];
            return response()->json($response);
        }

        // dd(env('API_KEY_TEMP'));  
        if ($request->header('api-key') !== env('API_KEY_TEMP')) {
            $response = [
                'status' => false,
                'code' => 500,
                'msg' => 'Unauthentication.',
                'version' => env('VERSION', "1.0.0"),
                'data' => []
            ];
            return response()->json($response);
        }
        return $next($request);
    }

}
