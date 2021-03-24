<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Yajra\DataTables\DataTables;
use App\product;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('product.form', ['btn' => 'Save', 'category' => Category::where(['status' => 'Active', 'perent_id' => 0])->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'category_id' => 'required',
            'name' => $request->id ? 'required|unique:products,name,' . $request->id : 'required|unique:products',
            'image' => 'required|max:5120',
            'descriptions' => 'required',
            'price' => 'required'
        ]);
        $product_data = ['category_id' => $request->category_id, 'name' => $request->name, 'descriptions' => $request->descriptions, 'price' => $request->price];
        if ($request->file('image')) {
            $image = $request->file('image');
            $new_name = Storage::disk('public')->put('', $image);
        }
        if ($request->file('image')) {
            $product_data['image'] = $new_name;
        }
        product::updateOrCreate(['id' => $request->id], $product_data);
        $massge = $request->id ? 'Product Updated successfully.' : 'Product Added successfully.';
        return redirect()->route('product.index')->with('success', 'Product successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    public function productData(Request $request) {
//        with(['parentCategory'])
        return Datatables::of(product::with(['category_data'])->orderBy('created_at', 'desc')->get())->addColumn('action', function ($product) {
                    return '<a href = "' . url('product/' . $product->id . '/edit') . '" style="margin-right: 10px;" class = "btn btn-primary">Edit</a><button type="button" class ="btn btn-danger delete-product" data-id = "' . $product->id . '" style="margin-right: 10px;">Delete</button>';
                })->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        return view('product.form', ['btn' => 'Update', 'category' => Category::where(['status' => 'Active', 'perent_id' => 0])->get(), 'product_data' => product::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        product::destroy($id);
        return response()->json(['status' => 'success', 'massage' => 'Category is successfully Deleted', 'data' => []], 200);
    }

}
