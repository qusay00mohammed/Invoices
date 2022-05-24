@extends('layouts.master')

@section('title', 'قائمة الفواتير')

@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!--Internal   Notify -->
<link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
  <div class="my-auto">
    <div class="d-flex">
      <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">
        @if ($paid == 1)
        / الفواتير المدفوعة
        @elseif($paid == 2)
        / الفواتير غير مدفوعة
        @elseif($paid == 3)
        / الفواتير المدفوعة جزئيا
        @elseif($paid == 4)
        / الفواتير المؤرشفة
        @else
        / قائمة الفواتير
        @endif
      </span>
    </div>
  </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')


@if (session()->has('delete'))
  <script>
    window.onload = function(){
      notif({
      msg: "تم الحذف بنجاح",
      type: "success"
      });
    }
  </script>
@endif

@if (session()->has('update'))
  <script>
    window.onload = function(){
      notif({
      msg: "تم التعديل بنجاح",
      type: "success"
      });
    }
  </script>
@endif

@if (session()->has('archive'))
  <script>
    window.onload = function(){
      notif({
      msg: "تمت عملية الارشفة بنجاح",
      type: "success"
      });
    }
  </script>
@endif

@if (session()->has('restore'))
  <script>
    window.onload = function(){
      notif({
      msg: "تمت استعادة الفاتورة بنجاح",
      type: "success"
      });
    }
  </script>
@endif







<!-- row -->
<div class="row">


  <div class="col-xl-12">
    <div class="card mg-b-20">
      <div class="card-header pb-0">
        {{-- <div class="d-flex justify-content-between"> --}}
          <a href="invoices/create" class="modal-effect btn btn-sm btn-primary" style="color:white"><i class="fas fa-plus"></i>&nbsp; اضافة فاتورة</a>

          <a href="{{ route('export_invoice_excel') }}" class="modal-effect btn btn-sm btn-primary pull-right" style="color:white"><i class="fas fa-file-download"></i>&nbsp;&nbsp;تصدير الفواتير</a>
        {{-- </div> --}}
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="example1" class="table key-buttons text-md-nowrap">
            <thead>
              <tr>
                <th class="border-bottom-0">#</th>
                <th class="border-bottom-0">رقم الفاتورة</th>
                <th class="border-bottom-0">تاريخ الفاتورة</th>
                <th class="border-bottom-0">تاريخ الاستحقاق</th>
                <th class="border-bottom-0">المنتج</th>
                <th class="border-bottom-0">القسم</th>
                <th class="border-bottom-0">الخصم</th>
                <th class="border-bottom-0">نسبة الضريبة</th>
                <th class="border-bottom-0">قيمة الضريبة</th>
                <th class="border-bottom-0">الأجمالي</th>
                <th class="border-bottom-0">الحالة</th>
                <th class="border-bottom-0">ملاحظات</th>
                <th class="border-bottom-0">العمليات</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($invoices as $key => $invoice)
              <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $invoice->invoice_num }}</td>
                <td>{{ $invoice->invoice_date }}</td>
                <td>{{ $invoice->due_date }}</td>
                <td>{{ $invoice->product }}</td>
                <td><a href="{{ route('invoiceDetails', ['id'=>$invoice->id]) }}">{{ $invoice->section->section_name
                    }}</a></td>
                <td>{{ $invoice->discount }}</td>
                <td>{{ $invoice->rate_vat }}</td>
                <td>{{ $invoice->value_vat }}</td>
                <td>{{ $invoice->total }}</td>
                <td>
                  @if ($invoice->value_status == 1)
                  <span style="color: green">{{ $invoice->status }}</span>
                  @elseif ($invoice->value_status == 2)
                  <span style="color: red">{{ $invoice->status }}</span>
                  @else
                  <span style="color: rgb(255, 230, 0)">{{ $invoice->status }}</span>
                  @endif
                </td>
                <td>{{ $invoice->note }}</td>

                <td>
                  <div class="dropdown">
                    <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary btn-sm" data-toggle="dropdown" type="button">العمليات<i class="fas fa-caret-down ml-1"></i></button>
                    <div class="dropdown-menu tx-13">
                      {{-- @can('تعديل الفاتورة') --}}
                      @if ($paid != 4)
                      <a class="dropdown-item" href="{{ route('invoices.edit', [$invoice->id]) }}"><i class="text-info fas fa-edit"></i>&nbsp;&nbsp;تعديل الفاتورة</a>
                      @endif
                      {{-- @endcan --}}


                      {{-- @can('حذف الفاتورة') --}}
                      <a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}" data-toggle="modal" data-target="#delete_invoice"><i class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف الفاتورة</a>
                      {{-- @endcan --}}

                      {{-- @can('تغير حالة الدفع') --}}
                      @if ($paid != 4)
                      <a class="dropdown-item" href="{{ route('invoices.show', [$invoice->id]) }}"><i class=" text-success fas fa-money-bill"></i>&nbsp;&nbsp;تغير حالة الدفع</a>
                      @endif
                      {{-- @endcan --}}

                      {{-- @can('ارشفة الفاتورة') --}}
                      @if ($paid != 4)
                      <a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}" data-toggle="modal" data-target="#Transfer_invoice"><i class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;نقل الي الارشيف</a>
                      @endif
                      {{-- @endcan --}}

                      @if ($paid == 4)
                      <a class="dropdown-item" href="#" data-invoice_id="{{ $invoice->id }}" data-toggle="modal" data-target="#restor_invoice"><i class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;نقل الي الفواتير</a>
                      @endif

                      {{-- @can('طباعةالفاتورة') --}}
                      <a class="dropdown-item" href="{{ route('print_invoice', ['id'=>$invoice->id]) }}"><i class="text-success fas fa-print"></i>&nbsp;&nbsp;طباعة الفاتورة
                      </a>
                      {{-- @endcan --}}
                    </div>
                  </div>

                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- حذف الفاتورة -->
  <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">حذف الفاتورة</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <form action="{{ route('invoices.destroy', 'test') }}" method="POST">
            {{ method_field('delete') }}
            {{ csrf_field() }}
        </div>
        <div class="modal-body">
          هل انت متاكد من عملية الحذف ؟
          <input type="hidden" name="invoice_id" id="invoice_id">
          <input type="hidden" name="del" value="1">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
          <button type="submit" class="btn btn-danger">تاكيد</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <!-- ارشفة الفاتورة -->
  <div class="modal fade" id="Transfer_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">ارشفة الفاتورة</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <form action="{{ route('invoices.destroy', 'test') }}" method="POST">
            {{ method_field('delete') }}
            {{ csrf_field() }}
        </div>
        <div class="modal-body">
          هل انت متاكد من عملية الارشفة ؟
          <input type="hidden" name="invoice_id" id="invoice_id">
          <input type="hidden" name="del" value="2">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
          <button type="submit" class="btn btn-success">تاكيد</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <!-- الغاء ارشفة الفاتورة -->
  <div class="modal fade" id="restor_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">إلغاء ارشفة الفاتورة</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <form action="{{ route('restore_invoice') }}" method="POST">
            {{ csrf_field() }}
        </div>
        <div class="modal-body">
          هل انت متاكد من عملية إلغاء الارشفة ؟
          <input type="hidden" name="invoice_id" id="invoice_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
          <button type="submit" class="btn btn-success">تاكيد</button>
        </div>
        </form>
      </div>
    </div>
  </div>


</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<!--Internal  Notify js -->
<script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
<script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>



<script>
  $('#delete_invoice').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget)
      var invoice_id = button.data('invoice_id')
      var modal = $(this)
      modal.find('.modal-body #invoice_id').val(invoice_id);
  })
</script>

<script>
  $('#Transfer_invoice').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget)
      var invoice_id = button.data('invoice_id')
      var modal = $(this)
      modal.find('.modal-body #invoice_id').val(invoice_id);
  })
</script>

<script>
  $('#restor_invoice').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget)
      var invoice_id = button.data('invoice_id')
      var modal = $(this)
      modal.find('.modal-body #invoice_id').val(invoice_id);
  })
</script>








@endsection
