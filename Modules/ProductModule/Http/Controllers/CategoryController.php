<?php

namespace Modules\ProductModule\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Imports\CategoryImport;
use Maatwebsite\Excel\Facades\Excel;
use Modules\ProductModule\Entities\Category;
use Modules\ProductModule\Entities\Product;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('productmodule::category.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('productmodule::category.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $get_cat=Category::where('category_slug',$id)->first();
        $total_products= count(Product::with('category')->where('category_id',$get_cat->id)->get());
        $products= Product::with('category')->where('category_id',$get_cat->id)->paginate(12);

        $latest= Product::with('category')->latest()->take(4)->get();
        // dd($products);
        $categories= Category::all();
        // return view('productmodule::show'));
        return view('productmodule::category.show',compact('products','categories','latest','total_products','get_cat'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('productmodule::category.edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }
    public function import_store(Request $request){
        // dd($request->all());
        Excel::import(new CategoryImport,request()->file('fileupload'));
        return redirect()->back()->with('message', 'Uploaded Successfully!!');


    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
