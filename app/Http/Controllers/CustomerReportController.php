<?php

namespace App\Http\Controllers;

use App\Section;
use App\Invoice;
use Illuminate\Http\Request;

class CustomerReportController extends Controller
{
  public function index()
  {
    $sections = Section::all();
    return view('report.customer_report', compact('sections'));
  }


  public function search_customers(Request $request)
  {
    if($request->section_id && $request->product && $request->start_at == '' && $request->end_at == '')
    {
      $section_id = $request->section_id;
      $product = $request->product;
      $invoices = Invoice::where(['section_id' => $section_id, 'product' => $product])->get();
      $sections = Section::all();
      return view('report.customer_report', compact('sections'))->withDetails($invoices);


    }else{
      $section_id = $request->section_id;
      $product = $request->product;
      $start = date($request->start_at);
      // dd($start);
      $end = date($request->end_at);
      $invoices = Invoice::where(['section_id' => $section_id, 'product' => $product])->whereBetween('invoice_date', [$start, $end])->get();
      $sections = Section::all();
      return view('report.customer_report', compact('start', 'end', 'sections', 'section_id', 'product'))->withDetails($invoices);
    }
  }




}
