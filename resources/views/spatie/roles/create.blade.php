@extends('layouts.master')
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{ URL::asset('assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{ URL::asset('assets/plugins/treeview/treeview-rtl.css') }}" rel="stylesheet" type="text/css" />
@section('title')
    اضافة مسمى وظيفة - مورا سوفت للادارة القانونية
@stop

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة نوع مستخدم</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')

  @if (count($errors) > 0)
      <div class="alert alert-danger">
          <button aria-label="Close" class="close" data-dismiss="alert" type="button">
              <span aria-hidden="true">&times;</span>
          </button>
          <strong>خطا</strong>
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif

{{-- {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!} --}}
<form action="{{ route('roles.store') }}" method="POST">
  @csrf
  <!-- row -->
<div class="row">
  <div class="col-md-12">
    <div class="card mg-b-20">
        <div class="card-body">
          <div class="main-content-label mg-b-5">
            <div class="col-xs-7 col-sm-7 col-md-7">
                {{-- <div class="form-group">
                    <label>Guard Name</label>
                    <select name="guard_name" required class="form-control">
                      <option value="super_admin">Super Admin</option>
                      <option value="admin">Admin</option>
                      <option value="user">user</option>
                    </select>
                </div> --}}


                <div class="form-group">
                  <label for="">اضافة مسمى وظيفي جديد</label>
                  <input type="text" class="form-control" name="name" placeholder="ادخل مسمى وظيفي جديد" required>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-main-primary">تاكيد</button>
              </div>

            </div>
          </div>
        </div>
    </div>
  </div>
</div>
</form>



</div>
</div>


@endsection
@section('js')
<!-- Internal Treeview js -->
<script src="{{ URL::asset('assets/plugins/treeview/treeview.js') }}"></script>
@endsection
