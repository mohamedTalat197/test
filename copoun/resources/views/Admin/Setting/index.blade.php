@extends('Admin.includes.layouts.master')

@section('title')
    {{$title}}

@endsection

@section('content')

    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-5 align-self-center">
                    <h4 class="page-title">{{getNameInIndexPage()}}</h4>
                    <div class="d-flex align-items-center">

                    </div>
                </div>
                <div class="col-7 align-self-center">
                    <div class="d-flex no-block justify-content-end align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{route('admin.dashboard')}}">الرشيسية</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{$title}} </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <!-- basic table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex no-block align-items-center m-b-30">
                                <h4 class="card-title">{{$title}}  </h4>
                                <div class="ml-auto">
                                </div>
                            </div>

                            <div class="table-responsive" style="overflow: hidden;">
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="sorting_asc" tabindex="0" aria-controls="file_export" rowspan="1"
                                            colspan="1" aria-sort="ascending"
                                            aria-label=" : activate to sort column descending" style="width: 0px;"></th>
                                        @if($type==1)
                                            <th>التلجرام</th>
                                            <th>الواتساب</th>
                                            <th>فايسبوك</th>
                                            <th>تويتر</th>
                                            <th>سناب شات</th>
                                        @elseif($type==3)
                                            <th>سياسة الخصوصية بالعربية</th>
                                            <th>سياسة الخصوصية بالانجليزية</th>
                                        @elseif($type==15)
                                            <th>من نحن بالعربية</th>
                                            <th>من نحن بالانجليزية</th>
                                        @else
                                            <th>صورة الشركة</th>
                                            <th>لوجو الشركة</th>
                                            <th>الهاتف</th>
                                            <th>الواتساب</th>
                                        @endif
                                        <th>تعديل {{$title}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Right sidebar -->
            <!-- ============================================================== -->
            <!-- .right-sidebar -->
            <!-- ============================================================== -->
            <!-- End Right sidebar -->
            <!-- ============================================================== -->
        </div>

        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
    @include('Admin.Setting.form')

    <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#showmenu').click(function () {
                $('.menuFilter').toggle("slide");
            });
        });
    </script>
    @include('Admin.Setting.script')

@endsection
