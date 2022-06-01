<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceDetails;
use App\Section;
use App\InvoiceAttachment;
use App\Notifications\AddInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Exports\InvoiceExport;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $this->authorize('قائمة الفواتير', Invoice::class);
    $paid = null;
    $invoices = Invoice::all();
    // $invoices = Invoice::withTrashed()->get();
    return view('invoices.invoices', compact('invoices', 'paid'));
  }

  public function paid_invoices()
  {
    $this->authorize('الفواتير المدفوعة', Invoice::class);
    $paid = 1;
    $invoices = Invoice::where('value_status', 1)->get();
    return view('invoices.invoices', compact('invoices', 'paid'));
  }

  public function unpaid_invoices()
  {
    $this->authorize('الفواتير الغير مدفوعة', Invoice::class);
    $paid = 2;
    $invoices = Invoice::where('value_status', 2)->get();
    return view('invoices.invoices', compact('invoices', 'paid'));
  }

  public function partPaid_invoices()
  {
    $this->authorize('الفواتير المدفوعة جزئيا', Invoice::class);
    $paid = 3;
    $invoices = Invoice::where('value_status', 3)->get();
    return view('invoices.invoices', compact('invoices', 'paid'));
  }

  public function archive_invoices()
  {
    $this->authorize('الفواتير المؤرشفة', Invoice::class);
    $paid = 4;
    $invoices = Invoice::onlyTrashed()->get();
    return view('invoices.invoices', compact('invoices', 'paid'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $this->authorize('اضافة فاتورة', Invoice::class);
    $sections = Section::all();
    return view('invoices.add_invoices', compact('sections'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->authorize('تخزين فاتورة', Invoice::class);
    Invoice::create([
      'invoice_num' => $request->invoice_num,
      'invoice_date' => $request->invoice_date,
      'due_date' => $request->due_date,
      'product' => $request->product,
      'section_id' => $request->section_id,
      'amount_collection' => $request->amount_collection,
      'amount_commission' => $request->amount_commission,
      'discount' => $request->discount,
      'value_vat' => $request->value_vat,
      'rate_vat' => $request->rate_vat,
      'total' => $request->total,
      'status' => 'غير مدفوعة',
      'value_status' => 2,
      'note' => $request->note,
    ]);



    // $input = $request->all();
    // $input['status'] = "غيرمدفوعة";
    // $input['value_status'] = "2";
    // Invoice::create($input);



    $invoice_id = invoice::latest()->first()->id;
    InvoiceDetails::create([
      'id_invoice' => $invoice_id,
      'user' => Auth::user()->name,
      'note' => $request->note,
      'value_status' => 2,
      'status' => 'غير مدفوعة',
      'section_id' => $request->section_id,
      'product' => $request->product,
      'invoice_number' => $request->invoice_num,
    ]);


    if ($request->hasFile("pic")) {

      $invoice_id = Invoice::latest()->first()->id;

      $image = $request->file("pic");
      $file_name = $image->getClientOriginalName();
      $invoice_number = $request->invoice_num;

      $attachments = new InvoiceAttachment();
      $attachments->file_name = $file_name;
      $attachments->invoice_number = $invoice_number;
      $attachments->created_by = Auth::user()->name;
      $attachments->invoice_id = $invoice_id;
      $attachments->save();

      // move pic
      $imageName = $request->pic->getClientOriginalName();
      $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
    }


    $user = Auth::user();
    // $user->notyfy(new AddInvoice($invoice_id));
    Notification::send($user, new AddInvoice($invoice_id));

    session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
    return back();
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Invoice  $invoice
   * @return \Illuminate\Http\Response
   */
  public function show(Invoice $invoice)
  {
    $this->authorize('حالة الفاتورة', Invoice::class);
    // dd($invoice);
    // dd(Auth::first());
    return view('invoices.status', compact('invoice'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Invoice  $invoice
   * @return \Illuminate\Http\Response
   */
  public function edit(Invoice $invoice)
  {
    $this->authorize('تعديل فاتورة', Invoice::class);
    $sections = Section::all();
    // dd($invoice);
    return view('invoices.edit_invoices', compact('sections', 'invoice'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Invoice  $invoice
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Invoice $invoice)
  {
    $this->authorize('تحديث فاتورة', Invoice::class);
    // return $invoice->id;
    $invoice->update([
      'invoice_num' => $request->invoice_num,
      'invoice_date' => $request->invoice_date,
      'due_date' => $request->due_date,
      'product' => $request->product,
      'section_id' => $request->section_id,
      'amount_collection' => $request->amount_collection,
      'amount_commission' => $request->amount_commission,
      'discount' => $request->discount,
      'value_vat' => $request->value_vat,
      'rate_vat' => $request->rate_vat,
      'total' => $request->total,
      'status' => 'غير مدفوعة',
      'value_status' => 2,
      'note' => $request->note,
    ]);

    session()->flash('update', 'تم التعديل بنجاح');
    return redirect()->route('invoices.index');
  }

  public function restore_invoice(Request $request)
  {
    $this->authorize('الغاء ارشفة الفاتورة', Invoice::class);
    $id = $request->invoice_id;
    $invoice = Invoice::onlyTrashed()->where('id', $id)->restore();
    session()->flash('restore');
    return redirect()->route('archive_invoices');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Invoice  $invoice
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
    $this->authorize('حذف فاتورة', Invoice::class);
    // $invoice = Invoice::where('id', $request->invoice_id)->first();
    $invoice = Invoice::withTrashed()->where('id', $request->invoice_id)->first();

    if ($request->del == 1) {
      $attachments = InvoiceAttachment::where('invoice_number', $invoice->invoice_num)->first();
      if (!empty($attachments->invoice_number)) {

        Storage::disk('public_upload')->deleteDirectory($attachments->invoice_number);
        // Storage::disk('public_upload')->delete($attachments->invoice_number . '/' . $attachments->file_name);
      }
      $invoice->forceDelete();
      session()->flash('delete');
    } else if ($request->del == 2) {
      // dd($invoice);
      $invoice->delete();
      session()->flash('archive');
    }
    return redirect()->route('invoices.index');
  }


  public function getProducts($id)
  {
    $products = DB::table("products")->where("section_id", $id)->pluck("product_name", "id");

    return json_encode($products);
  }

  public function status_update($id, Request $request)
  {
    $this->authorize('تحديث حالة الدفع', Invoice::class);
    $invoice = Invoice::findOrFail($id);
    if ($request->status == "مدفوعة") {
      $invoice->update([
        'status'        => 'مدفوعة',
        'value_status'  => 1,
        'payment_date'  => $request->payment_date,
      ]);

      InvoiceDetails::create([
        'invoice_number' => $request->invoice_num,
        'product'        => $request->product,
        'section_id'     => $request->section_id,
        'status'         => 'مدفوعة',
        'value_status'   => 1,
        'payment_date'   => $request->payment_date,
        'note'           => $request->note,
        'user'           => auth::user()->name,
        'id_invoice'     => $id,
      ]);
    } else {
      $invoice->update([
        'status'        => 'مدفوعة جزئيا',
        'value_status'  => 3,
        'payment_date'  => $request->payment_date,
      ]);

      InvoiceDetails::create([
        'invoice_number' => $request->invoice_num,
        'product'        => $request->product,
        'section_id'     => $request->section_id,
        'status'         => 'مدفوعة جزئيا',
        'value_status'   => 3,
        'payment_date'   => $request->payment_date,
        'note'           => $request->note,
        'user'           => auth::user()->name,
        'id_invoice'     => $id,
      ]);
    }
    session()->flash('update');
    return redirect()->route('invoices.index');
  }


  public function print_invoice($id)
  {
    $invoice = Invoice::where('id', $id)->first();
    return view('invoices.print_invoice', compact('invoice'));
  }



  public function export(Excel $excel)
  {
    // return Excel::download(new InvoiceEcport, 'invoices.xlsx');
    // return (new InvoiceExport)->download('invoices.xlsx');  // Exportable
    // return new InvoiceExport; //Responsable
    // return $excel->download(new InvoiceExport, 'invoices.xlsx');
    // return $excel->download(new InvoiceExport, 'invoices.csv', Excel::CSV); // Export formats
    // Export PDF install library pdf
    // ex: composer require barryvdh/laravel-dompdf
    // return $excel->download(new InvoiceExport, 'invoices.pdf', Excel::DOMPDF); // Export formats
    return $excel->download(new InvoiceExport, 'invoices.xlsx'); // Export formats


  }
}
