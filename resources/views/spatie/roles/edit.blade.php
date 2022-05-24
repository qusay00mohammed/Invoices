@extends('layouts.master')
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{ URL::asset('assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{ URL::asset('assets/plugins/treeview/treeview-rtl.css') }}" rel="stylesheet" type="text/css" />
@section('title')
    تعديل الصلاحيات - مورا سوفت للادارة القانونية
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الصلاحيات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل
                الصلاحيات</span>
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
<form action="{{ route('roles.update', [$role->id]) }}" method="POST">
  @csrf
  @method('PUT')
  <!-- row -->
<div class="row">
  <div class="col-md-12">
    <div class="card mg-b-20">
        <div class="card-body">
          <div class="main-content-label mg-b-5">
            <div class="col-xs-7 col-sm-7 col-md-7">
                <div class="form-group">
                    <label>اسم الصلاحية :</label>
                    <select name="guard_name" required class="form-control">
                      <option {{ $role->guard_name == 'super_admin' ? 'selected' : '' }} value="super_admin">Super Admin</option>
                      <option {{ $role->guard_name == 'admin' ? 'selected' : '' }} value="admin">Admin</option>
                      <option {{ $role->guard_name == 'user' ? 'selected' : '' }} value="user">user</option>
                    </select>
                </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-4">
              <label for="">الاسم</label>
              <input type="text" value="{{ $role->name }}" class="form-control" name="name" placeholder="ادخل اسم الصلاحية" required>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-main-primary">تحديث</button>
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
