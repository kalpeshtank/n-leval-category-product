<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Validator;

class CategoryController extends Controller {

    public function getCategory() {
        return Helper::success("success", Category::where(['status' => 'Active'])->get());
    }

}
