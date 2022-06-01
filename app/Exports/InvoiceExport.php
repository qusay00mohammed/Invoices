<?php

namespace App\Exports;

use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InvoiceExport implements FromCollection, Responsable, WithHeadings, ShouldAutoSize
// class InvoiceExport implements FromArray
// class InvoiceExport implements FromView, ShouldAutoSize
{
  use Exportable;

  private $fileName = 'invoices.xlsx';
  /**
   * @return \Illuminate\Support\Collection
   */


    public function collection()
    {
      // return Invoice::all();
      return Invoice::select('invoice_num', 'invoice_date', 'due_date','product', 'section_id', 'amount_collection','amount_commission', 'discount', 'rate_vat','value_vat', 'total', 'status', 'note', 'payment_date')->get(); // ex:

      // return new Collection([
      //   ['Qusay', 'qusay@gmail.com']
      // ]);
    }

    public function headings() : array  // Mapping Data
    {
      return [
        'Invoice number',
        'Invoice Date',
        'Due Date',
        'Product',
        'Section ID',
        'Amount Collection',
        'Amount Commission',
        'Discount',
        'Rate Vat',
        'Value Vat',
        'total',
        'Status',
        'note',
        'Payment Date',
      ];
    }






/*
  // public function array(): array
  // {
  //   return [
  //     ['Qusay', 'qusay@gmail.com']
  //   ];
  // }
*/

  // public function view() : View
  // {

  //   return view('export.invoices',[
  //     'invoices' => Invoice::all()
  //   ]);
  // }


}
