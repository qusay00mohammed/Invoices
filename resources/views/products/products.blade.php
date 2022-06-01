@extends('layouts.master')

@section('title', 'المنتجات')

@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
  <div class="my-auto">
    <div class="d-flex">
      <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
        المنتجات</span>
    </div>
  </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">



  @if (session()->has('add'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('add') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif

  @if (session()->has('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('error') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif

  @if (session()->has('edit'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('edit') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif

  @if (session()->has('delete'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('delete') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif

  <!-- /resources/views/post/create.blade.php -->
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  <!-- Create Post Form -->















  <div class="col-xl-12">
    <div class="card mg-b-20">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between">
          <div class="col-sm-6 col-md-4 col-xl-3">
            <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal"
              href="#modaldemo8">إضافة منتج</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'>
            <thead>
              <tr>
                <th class="border-bottom-0">#</th>
                <th class="border-bottom-0">اسم المنتج</th>
                <th class="border-bottom-0">اسم القسم</th>
                <th class="border-bottom-0">الملاحظات</th>
                <th class="border-bottom-0">العمليات</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($products as $key => $item)
              <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->section['section_name'] }}</td>
                <td>{{ $item->description }}</td>
                <td>
                  <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale" data-id="{{ $item->id }}"
                    data-product_name="{{ $item->product_name }}" data-description="{{ $item->description }}"
                    data-section_name="{{ $item->section['section_name'] }}" data-toggle="modal" href="#edit_Product"
                    title="تعديل"><i class="las la-pen"></i></a>

                  <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-id="{{ $item->id }}"
                    data-product_name="{{ $item->product_name }}" data-toggle="modal" href="#modaldemo9" title="حذف"><i
                      class="las la-trash"></i></a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>






  <!-- add -->
  <div class="modal" id="modaldemo8">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content modal-content-demo">
        <div class="modal-header">
          <h6 class="modal-title">إضافة منتج</h6><button aria-label="Close" class="close" data-dismiss="modal"
            type="button"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">

          <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="">اسم المنتج</label>
              <input class="form-control" type="text" name="product_name" required>
            </div>

            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
            <select name="section_id" id="section_id" class="form-control" required>
              <option value="" selected disabled> --حدد القسم--</option>
              @foreach ($sections as $sec)
              <option value="{{ $sec->id }}">{{ $sec->section_name }}</option>
              @endforeach
            </select>

            <div class="form-group">
              <label for="">ملاحظات</label>
              <input class="form-control" type="text" name="description" required>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success">تأكيد</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>

  <!-- edit -->
  <div class="modal fade" id="edit_Product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">تعديل منتج</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action='{{ route('products.update', 'test') }}' method="POST">
          @csrf
          @method('put')
          <div class="modal-body">
            <input type="hidden" class="form-control" name="id" id="pro_id">
            <div class="form-group">
              <label for="title">اسم المنتج :</label>
              <input type="text" class="form-control" name="product_name" id="product_name" required>
            </div>

            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
            <select name="section_id" id="section_name" class="custom-select my-1 mr-sm-2" required>
              @foreach ($sections as $section)
              <option>{{ $section->section_name }}</option>
              @endforeach
            </select>

            <div class="form-group">
              <label for="des">ملاحظات :</label>
              <textarea name="description" cols="20" rows="5" id='description' class="form-control"></textarea>
            </div>

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">تعديل البيانات</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- delete -->
  <div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">حذف المنتج</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="products/destroy" method="post">
          {{ method_field('delete') }}
          {{ csrf_field() }}
          <div class="modal-body">
            <p>هل انت متاكد من عملية الحذف ؟</p><br>
            <input type="hidden" name="id" id="id">
            <input class="form-control" name="product_name" id="product_name" type="text" readonly>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
            <button type="submit" class="btn btn-danger">تاكيد</button>
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
<script src="{{URL::asset('assets/js/modal.js')}}"></script>



<script>

// Edit
  $('#edit_Product').on('show.bs.modal', function(event) {
  var button = $(event.relatedTarget)
  var product_name = button.data('product_name')
  var section_name = button.data('section_name')
  var pro_id = button.data('id')
  var description = button.data('description')
  var modal = $(this)
  modal.find('.modal-body #product_name').val(product_name);
  modal.find('.modal-body #section_name').val(section_name);
  modal.find('.modal-body #description').val(description);
  modal.find('.modal-body #pro_id').val(pro_id);
})

// Delete
$('#modaldemo9').on('show.bs.modal', function(event) {
  var button = $(event.relatedTarget)
  var id = button.data('id')
  var product_name = button.data('product_name')
  var modal = $(this)
  modal.find('.modal-body #id').val(id);
  modal.find('.modal-body #product_name').val(product_name);
})

</script>



@endsection
