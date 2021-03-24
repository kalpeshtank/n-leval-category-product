<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('category.index');
    }

    public function categoryData(Request $request) {
        return Datatables::of(Category::with(['parentCategory'])->orderBy('created_at', 'desc')->get())->addColumn('action', function ($category) {
                    return '<a href = "' . url('category/' . $category->id . '/edit') . '" style="margin-right: 10px;" class = "btn btn-primary">Edit</a><button type="button" class ="btn btn-danger delete-category" data-id = "' . $category->id . '" style="margin-right: 10px;">Delete</button>';
                })->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('category.form', ['btn' => 'Save', 'category' => Category::where(['status' => 'Active'])->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name' => $request->id ? 'required|unique:categories,name,' . $request->id : 'required|unique:categories',
        ]);
        Category::updateOrCreate(['id' => $request->id], ['name' => $request->name, 'perent_id' => $request->perent_id, 'status' => $request->status]);
        $massge = $request->id ? 'Category Updated successfully.' : 'Category Added successfully.';
        return redirect()->route('category.index')->with('success', $massge);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        return view('category.form', ['btn' => 'Update', 'category' => Category::where('id', '!=', $id)->where(['status' => 'Active'])->get(), 'category_data' => Category::find($id)]);
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
        Category::destroy($id);
        return response()->json(['status' => 'success', 'massage' => 'Category is successfully Deleted', 'data' => []], 200);
    }

}
