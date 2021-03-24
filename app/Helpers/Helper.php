<?php

namespace App\Helpers;

use Request;

class Helper {

    public static function shout(string $string) {
        return strtoupper($string);
    }

    public static function res($data, $msg, $code) {
        $response = [
            'status' => $code == 200 || $code == 201 ? true : false,
            'code' => $code,
            'msg' => $msg,
            'version' => env('VERSION', "1.0.0"),
            'data' => $data
        ];
        return $response;
    }

    public static function success($msg = 'Success', $data = [], $status = 200) {
        return Helper::res($data, $msg, $status);
    }

    public static function fail($msg = "Some thing wen't wrong!", $data = [], $status = 400) {
        return Helper::res($data, $msg, $status);
    }

}
