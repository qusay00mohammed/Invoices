<?php

namespace App\Http\Controllers;

use App\Section;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Auth;

class SectionController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $this->authorize('الاقسام', Section::class);
    $section = Section::all();
    return view('sections.section', compact('section'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $this->authorize('اضافة قسم', Section::class);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->authorize('تخزين قسم', Section::class);
    // $exist = Section::where('section_name', '=', $input['section_name'])->exists();
    $input = $request->all();
    $request->validate([
      'section_name' => 'required|unique:sections',
      'description'  => 'required',
    ], [
      'section_name.required' => 'اسم القسم مطلوب',
      'section_name.unique' => 'اسم القسم مكرر',
    ]);
    $input['created_by'] = Auth::user()->name;
    Section::create($input);
    return redirect()->route('section.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Section  $section
   * @return \Illuminate\Http\Response
   */
  public function show(Section $section)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Section  $section
   * @return \Illuminate\Http\Response
   */
  public function edit(Section $section)
  {
    $this->authorize('تعديل قسم', Section::class);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Section  $section
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    $this->authorize('تحديث قسم', Section::class);
    // dd($request->all());
    $id = $request->id;
    $input = $request->all();
    $section = Section::findOrFail($id);
    $request->validate([
      'section_name' => 'required|unique:sections,section_name,' . $id,
      'description'  => 'required',
    ], [
      'section_name.required' => 'اسم القسم مطلوب',
      'section_name.unique' => 'اسم القسم مكرر',
    ]);

    $update = $section->update($input);
    session()->flash('edit', 'تم التعديل بنجاح');
    return redirect()->route('section.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Section  $section
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
    $this->authorize('حذف قسم', Section::class);
    $id = $request->id;
    $section = Section::findOrFail($id)->delete();

    // $delete = $section->delete();

    session()->flash('delete', 'تم الحذف بنجاح');
    return redirect()->route('section.index');
  }
}
