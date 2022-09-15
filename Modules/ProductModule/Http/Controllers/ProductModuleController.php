<?php

namespace Modules\ProductModule\Http\Controllers;

// use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ProductModule\Entities\Product;
use Modules\ProductModule\Transformers\ProductResource;
use Symfony\Component\HttpFoundation\Response;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;
use Modules\ProductModule\Entities\Category;

class ProductModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        // $data=Product::all();


        // return response(new ProductResource($data),Response::HTTP_ACCEPTED);
        return view('productmodule::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('productmodule::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Request $req, $id)
    {

        $products= Product::with('category')->where('slug',$id)->first();

        $latest= Product::with('category')->latest()->take(4)->get();
        // dd($latest);
        $categories= Category::all();

        if($req->data=='fromAjax'){
            return response()->json(['products' => $products]);

        }

        return view('productmodule::show',compact('products','categories','latest'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('productmodule::edit');
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

    public function import(){
        return view('productmodule::import');
    }
    public function import_store(Request $request){
        // dd($request->all());
        Excel::import(new ProductImport,request()->file('fileupload'));
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
