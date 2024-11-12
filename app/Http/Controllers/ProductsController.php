<?php

namespace App\Http\Controllers;

use App\Models\products;
use Illuminate\Http\Request;
use App\Models\sections;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = products::all();
        $sections = sections::all();
        return view('products.products', compact('products', 'sections'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        products::create(
            [
                'section_id' => $request->sections_id,
                'product_name' => $request->product_name,
                'description' => $request->description,

            ]
        );
        session()->flash('Add', 'تم اضافة المنتج بنجاح');

        return redirect('product');
    }

    /**
     * Display the specified resource.
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, products $products)
    {
        $id = sections::where('sections_name', $request->sections_name)->first()->id;

        $products = products::findorFail($request->pro_id);

        $products->update([
            'section_id' => $id,
            'product_name' => $request->product_name,
            'description' => $request->description,
            //'sections_id' => $id,
        ]);
        session()->flash('Edit', 'تم تعديل المنتج بنجاح');

        return back();
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $products = products::findorFail($request->pro_id);
        $products->delete();
        session()->flash('delete', 'تم حذف المنتج بنجاح');
        return back();

        //
    }
}
