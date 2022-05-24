<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

class InvoiceAttachmentController extends Controller
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
        // dd('qsay');
      $this->validate($request, [
        'file_name' => 'mimes:pdf,jpeg,png,jpg',
        ], [
            'file_name.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
        ]);

        $image = $request->file('file_name');
        $file_name = $image->getClientOriginalName();

        $attachments =  new InvoiceAttachment();
        $attachments->file_name = $file_name;
        $attachments->invoice_number = $request->invoice_number;
        $attachments->invoice_id = $request->invoice_id;
        $attachments->Created_by = Auth::user()->name;
        $attachments->save();

        // move pic
        $imageName = $request->file_name->getClientOriginalName();
        $request->file_name->move(public_path('Attachments/'. $request->invoice_number), $imageName);

        session()->flash('Add', 'تم اضافة المرفق بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceAttachment $invoiceAttachment, $invoice_num, $file_name)
    {
        // dd($file_name);
      $file = Storage::disk('public_upload')->getDriver()->getAdapter()->applyPathPrefix($invoice_num . '/' . $file_name);
      return response()->file($file);
    }

    public function download($invoice_num, $file_name)
    {
      // dd($file_name);
      $file = Storage::disk('public_upload')->getDriver()->getAdapter()->applyPathPrefix($invoice_num . '/' . $file_name);
      return response()->download($file);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceAttachment $invoiceAttachment)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoiceAttachment $invoiceAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceAttachment $invoiceAttachment, Request $request)
    {
      $invoice = InvoiceAttachment::findOrFail($request->id_file);
      $invoice->delete();
      Storage::disk('public_upload')->delete($request->invoice_number . '/' . $request->file_name);
      session()->flash('delete', 'تم الحذف بنجاح');
      return back();
    }
}
