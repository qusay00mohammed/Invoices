@extends('layouts.master')
@section('css')
<!--Internal   Notify -->
<link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@section('title')
المسمى الوظيفي للمستخدمين - مورا سوفت للادارة القانونية
@stop


@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> / المسمى الوظيفي للمستخدمين</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')


@if (session()->has('add'))
<script>
    window.onload = function() {
        notif({
            msg: " تمت اضافة مسمى وظيفي جديد بنجاح"
            , type: "success"
        });
    }
</script>
@endif

@if (session()->has('not_add'))
<script>
    window.onload = function() {
        notif({
            msg: "فشلت عملية الاضافة"
            , type: "success"
        });
    }

</script>
@endif

@if (session()->has('edit'))
<script>
    window.onload = function() {
        notif({
            msg: " تم تحديث بيانات الوظيفة بنجاح"
            , type: "success"
        });
    }

</script>
@endif

@if (session()->has('delete'))
<script>
    window.onload = function() {
        notif({
            msg: " تم حذف اسم الوظيفة بنجاح بنجاح"
            , type: "error"
        });
    }

</script>
@endif

@if (session()->has('update'))
<script>
    window.onload = function() {
        notif({
            msg: " تم تحديث اسم الوظيفة بنجاح"
            , type: "success"
        });
    }

</script>
@endif
<!-- row -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('roles.create') }}">اضافة</a>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mg-b-0 text-md-nowrap table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>المسمى الوظيفي للمستخدمين</th>
                                <th>Guard Name</th>
                                <th>عدد الصلاحيات</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $key => $role)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->guard_name }}</td>
                                <td><a href="{{ route('roles.permissions.index', [$role->id]) }}" class="btn btn-info btn-sm">( {{ $role->permissions_count }} ) صلاحية</a></td>
                                <td>
                                    {{-- <a class="btn btn-success btn-sm" href="{{ route('roles.show', $role->id) }}">عرض</a> --}}

                                    <a class="btn btn-primary btn-sm" href="{{ route('roles.edit', [$role->id]) }}">تعديل</a>

                                    <a class="btn btn-danger btn-sm" href="{{ route('roles.delete', [$role->id]) }}">حذف</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/div-->
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Notify js -->
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection
