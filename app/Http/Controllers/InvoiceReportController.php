<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;

class InvoiceReportController extends Controller
{
  public function index()
  {
    return view('report.invoice_report');
  }

  public function search_invoices(Request $request)
  {
    $radio = $request->radio;
    if($radio == 1)
    {
      if ($request->type && $request->start_at == '' && $request->end_at == '')
      {
        $invoices = Invoice::select('*')->where(["status" => $request->type])->get();
        $type = $request->type;
        return view('report.invoice_report', compact('type'))->withDetails($invoices);
      }
      else
      {
        $start = date($request->start_at);
        $end = date($request->end_at);
        $type = $request->type;

        $invoices = Invoice::whereBetween('invoice_date', [$start, $end])->where('status', $request->type)->get();
        return view('report.invoice_report', compact('type', 'start', 'end'))->withDetails($invoices);
      }

    }
    else
    {
      $invoices = Invoice::where('invoice_num', $request->invoice_number)->get();
      return view('report.invoice_report')->withDetails($invoices);
    }

  }

}
