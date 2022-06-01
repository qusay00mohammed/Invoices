@extends('layouts.master')
@section('css')
<!--Internal   Notify -->
<link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@section('title')
صلاحيات المستخدمين - مورا سوفت للادارة القانونية
@stop


@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">وظائف المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> / الصلاحيات </span>
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
            msg: " تم اضافة الصلاحية بنجاح"
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
            msg: " تم تحديث بيانات الصلاحية بنجاح"
            , type: "success"
        });
    }

</script>
@endif

@if (session()->has('delete'))
<script>
    window.onload = function() {
        notif({
            msg: " تم حذف الصلاحية بنجاح"
            , type: "error"
        });
    }

</script>
@endif

@if (session()->has('update'))
<script>
    window.onload = function() {
        notif({
            msg: " تم تحديث الصلاحية بنجاح"
            , type: "success"
        });
    }

</script>
@endif
<!-- row -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mg-b-0 text-md-nowrap table-hover ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم الصلاحية</th>
                                {{-- <th>Guard Name</th> --}}
                                <th>اختيار الصلاحية</th>
                            </tr>
                        </thead>
                        <tbody>
                          <form action="">
                            @foreach ($permissions as $key => $permission)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>
                                  <input
                                  @foreach ($rolePermissions as $rolePermission)
                                  {{ $rolePermission->name == $permission->name ? 'checked' : '' }}
                                  @endforeach
                                  type="checkbox" name="{{ $permission->name }}" value="{{ $permission->name }}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <br><br>
                <input class="btn btn-success" type="submit" value="اعطاء الصلاحيات المحددة">
                </form>
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
