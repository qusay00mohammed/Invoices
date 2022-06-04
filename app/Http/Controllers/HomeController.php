<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */

  public function index()
  {
    //=================احصائية نسبة تنفيذ الحالات======================


    $count_all = Invoice::count();
    $count_invoices1 = Invoice::where('value_status', 1)->count();
    $count_invoices2 = Invoice::where('value_status', 2)->count();
    $count_invoices3 = Invoice::where('value_status', 3)->count();

    if($count_all == 0) {
      $invoice1 = 0;
      $invoice2 = 0;
      $invoice3 = 0;
    }else {
      $invoice1 = $count_invoices1 / $count_all * 100;
      $invoice2 = $count_invoices2 / $count_all * 100;
      $invoice3 = $count_invoices3 / $count_all * 100;
    }

    $chartjs = app()->chartjs
      ->name('barChartTest')
      ->type('bar')
      ->size(['width' => 250, 'height' => 141])
      ->labels(['الفواتير المدفوعة', 'الفواتير الغير المدفوعة', 'الفواتير المدفوعة جزئيا'])
      ->datasets([
        [
          "label" => "الفواتير المدفوعة",
          'backgroundColor' => ['#81b214'],
          'data' => [$invoice1],
        ],
        [
          "label" => "الفواتير الغير المدفوعة",
          'backgroundColor' => ['#ec5858'],
          'data' => [$invoice2],
        ],
        [
          "label" => "الفواتير المدفوعة جزئيا",
          'backgroundColor' => ['#ff9642'],
          'data' => [$invoice3],
        ],
      ])
      ->options([]);


    $chartjs_2 = app()->chartjs
      ->name('pieChartTest')
      ->type('pie')
      ->size(['width' => 250, 'height' => 200])
      ->labels(['الفواتير المدفوعة', 'الفواتير الغير المدفوعة', 'الفواتير المدفوعة جزئيا'])
      ->datasets([
        [
          'backgroundColor' => ['#81b214', '#ec5858', '#ff9642'],
          'data' => [$invoice1, $invoice2, $invoice3]
        ]
      ])
      ->options([]);

    return view('home', compact('chartjs', 'chartjs_2'));
  }

}
