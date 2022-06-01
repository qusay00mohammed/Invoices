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
    $this->authorize('المنتجات', Product::class); // Policy
    $sections = Section::all();
    $products = Product::all();
    return view('products.products', compact('sections', 'products'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $this->authorize('اضافة منتج', Product::class);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->authorize('تخزين منتج', Product::class);
    $input = $request->all();
    $request->validate([
      'product_name' => 'required',
      'section_id'   => 'required',
      'description'  => 'required',
    ]);

    Product::create($input);
    session()->flash('add', 'تم اضافة المنتج بنجاح');
    return redirect()->route('products.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function show(Product $product)
  {
    // $this->authorize('show', Product::class);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function edit(Product $product)
  {
    $this->authorize('تعديل منتج', Product::class);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    $this->authorize('تحديث منتج', Product::class);
    $input = $request->all();
    $input['section_id'] = Section::where('section_name', $request->section_id)->first()->id;
    $product = Product::findOrFail($request->id);
    $request->validate([
      'product_name' => 'required',
      'section_id'   => 'required',
      'description'  => 'required',
    ]);
    $update = $product->update($input);

    session()->flash('edit', 'تم تعديل المنتج بنجاح');
    return redirect()->back();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
    $this->authorize('حذف منتج', Product::class);
    $product = Product::findOrFail($request->id);
    $product->delete();

    session()->flash('delete', 'تم الحذف بنجاح');
    return redirect()->back();

  }




}
