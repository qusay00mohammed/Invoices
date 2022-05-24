<?php

namespace App\Http\Controllers;

use App\InvoiceDetails;
use Illuminate\Http\Request;
use App\Invoice;
use App\InvoiceAttachment;


class InvoiceDetailsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
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
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\InvoiceDetails  $invoiceDetails
   * @return \Illuminate\Http\Response
   */
  public function show(InvoiceDetails $invoiceDetails)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\InvoiceDetails  $invoiceDetails
   * @return \Illuminate\Http\Response
   */
  public function edit(InvoiceDetails $invoiceDetails, $id)
  {
    // dd($id);
    // dd('qusay');
    $invoices = Invoice::where("id", $id)->first();
    // dd($invoices) ;
    $details = InvoiceDetails::where('id_invoice', $id)->get();
    $attachments = InvoiceAttachment::where('invoice_id', $id)->get();

    return view('invoices.details_invoice', compact('invoices', 'details', 'attachments'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\InvoiceDetails  $invoiceDetails
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, InvoiceDetails $invoiceDetails)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\InvoiceDetails  $invoiceDetails
   * @return \Illuminate\Http\Response
   */
  public function destroy(InvoiceDetails $invoiceDetails)
  {
    //
  }
}
