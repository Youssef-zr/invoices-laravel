<?php

namespace App\Http\Controllers;

use App\Product;
use App\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'المنتجات';
        $sections = Section::all()->pluck('section_name', "id")->toArray();
        $products = Product::all();

        return view('admin.products.index', compact('title', 'sections','products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'product_name' => "required|string|max:255|unique:products,product_name",
            'section_id' => "required|numeric",
            'note' => 'nullable|min:5',
        ];

        $niceNames = [
            'product_name' => "اسم المنتج",
            'section_id' => "قسم المنتج",
            'note' => "الملاحظات",
        ];

        $data = $this->validate($request, $rules, [], $niceNames);
        
        $new = new Product();
        $new->fill($data)->save();

        $request->session()->flash('msgSuccess', 'تم اضافة المنتج بنجاح');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $rules = [
            'product_name' => "required|string|max:255|unique:products,product_name,".$product->id,
            'section_id' => "required|numeric",
            'note' => 'nullable|min:5',
        ];

        $niceNames = [
            'product_name' => "اسم المنتج",
            'section_id' => "قسم المنتج",
            'note' => "الملاحظات",
        ];

        // use this session to show the form of edit in blade if has errors
        $request->session()->flash('edit', 'edit');
        
        $data = $this->validate($request, $rules, [], $niceNames);
        
        $product->fill($data)->save();

        $request->session()->flash('msgSuccess', 'تم تعديل المنتج بنجاح');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Product $product)
    {
       $product->delete();

       $request->session()->flash('msgSuccess', 'تم حذف المنتج بنجاح');
       return redirect()->back();
    }
}
