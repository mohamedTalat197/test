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
                                    <a href="{{route('admin.dashboard')}}">الرئيسية</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
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
                    <div class="Notificationd">
                        <div class="Notificationd-body">
                            <div class="d-flex no-block align-items-center m-b-30">
                                <h4 class="Notificationd-title">{{$title}} </h4>
                                <div class="ml-auto">
                                    <div class="btn-group">

                                        <button  class="btn btn-dark" id="titleOfText" data-toggle="modal" onclick="addFunction()">
                                            اضافة اشعار جديدة
                                        </button>
                                        &nbsp;

                                    </div>

                                </div>
                            </div>


                            <div class="table-responsive" style="overflow: hidden;">
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>العنوان</th>
                                        <th>النوع</th>
                                        <th>اختيارات</th>

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
    @include('Admin.Notification.form')

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
    @include('Admin.Notification.script')

@endsection
