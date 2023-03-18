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
                    <div class="Coupond">
                        <div class="Coupond-body">
                            <div class="d-flex no-block align-items-center m-b-30">
                                <h4 class="Coupond-title">{{$title}} </h4>
                                <div class="ml-auto">
                                    <div class="btn-group">
                                        <button type="button" id="showmenu" class="btn btn-dark fillterNew">
                                            <i class="fas fa-filter"></i>
                                        </button>
                                        &nbsp;
                                        <button  class="btn btn-dark" id="titleOfText" data-toggle="modal" onclick="addFunction()">
                                            اضافة كوبون جديدة
                                        </button>
                                        &nbsp;
                                        <button class="btn btn-danger " data-toggle="modal"
                                                onclick="deleteFunction(0,2)">
                                            حذف المحدد
                                        </button>

                                    </div>

                                </div>
                            </div>

                            <div class="menuFilter" style="display: none;">
                                <form id="seachForm">
                                    <div class="row">

                                        <div class="col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <select name="status" class="custom-select mr-sm-2"
                                                        id="inlineFormCustomSelect">
                                                    <option value="">الحالة</option>
                                                    <option value="1">مفعل</option>
                                                    <option value="2">غير مفعل</option>
                                                </select>
                                            </div>
                                        </div>

                                      <input type="hidden" name="user_id" value="{{$user_id}}">

                                        <div class="col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <select name="isSpecial" class="custom-select mr-sm-2"
                                                        id="inlineFormCustomSelect">
                                                    <option value="">كود مميز</option>
                                                    <option value="1">نعم</option>
                                                    <option value="2">لا</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <select name="cat_id" class="custom-select mr-sm-2"
                                                        id="inlineFormCustomSelect">
                                                    <option value="">القسم</option>
                                                    @foreach($cats as $row)
                                                        <option value="{{$row->id}}">{{$row->name_ar}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <select name="country_id" class="custom-select mr-sm-2"
                                                        id="inlineFormCustomSelect">
                                                    <option value="">البلد</option>
                                                @foreach($countries as $row)
                                                        <option value="{{$row->id}}">{{$row->name_ar}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <select name="userClick" class="custom-select mr-sm-2"
                                                        id="inlineFormCustomSelect">
                                                    <option value="">تفعال الاعضاء</option>
                                                    <option value="1">الكود فعال</option>
                                                    <option value="2">الكود غير فعال</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-1">
                                            <div class="form-actions">
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-info">بحث</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="table-responsive" style="overflow: hidden;">
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="sorting_asc" tabindex="0" aria-controls="file_export" rowspan="1"
                                            colspan="1" aria-sort="ascending"
                                            aria-label=" : activate to sort column descending" style="width: 0px;"></th>
                                        <th>#</th>
                                        <th>صورة المتجر</th>
                                        <th>اسم المتجر </th>
                                        <th>اسم الكود </th>
                                        <th>القسم </th>
                                        <th>حالة التفعيل </th>
                                        <th>نقرات فعال </th>
                                        <th>نقرات غير فعال </th>
                                        <th>تاريخ الانتهاء </th>
                                        <th>التقييم </th>
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
    @include('Admin.Coupon.show')
    @include('Admin.Coupon.form')

    <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
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
    @include('Admin.Coupon.script')

@endsection
