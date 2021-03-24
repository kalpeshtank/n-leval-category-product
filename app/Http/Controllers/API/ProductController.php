<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\product;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProductController extends Controller {

    public function getProduct(Request $request) {
        $product = product::orderBy('id', 'ASC');
        if ($request->has('category_id')) {
            $product->where(['category_id' => $request->category_id]);
        }
        return Helper::success("success", $product->get());
    }

}
