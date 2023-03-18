@extends('Fronted.layouts.master')@section('title')    {{trans('main.ask_property')}}@endsection@section('content')    <section id="content">        <div id="content-wrap">            <section class="page-header content-header page-header-xs">                <div class="container">                    <!-- breadcrumbs -->                    <ul id="breadcrumbs">                        <li><a href="/">{{trans('main.home')}}</a></li>                        <li>{{trans('main.ask_property')}}</li>                    </ul>                </div>            </section>            <div class="section-content sm-pd">                <div class="container">                    <div class="row">                        <div class="col-md-6 col-md-offset-3">                            <div class="section-title ">                                <img src="/Fronted/images/content-img/about.png" alt="" />                            </div>                        </div>                    </div>                    <div class="row">                        <div class="col-md-8 col-md-offset-2 cust-pd-rt cust-div-display">                            <div class="section-title text-center  title-right" style="padding:0">                                <h2 class="contract-title job_title">   بيانات العقار </h2>                                <div style="margin-top:43px;" class="wow animated fadeInRightBig" data-wow-delay="0.8s">                                    <form id="add-form">                                        <div class="col-md-4 col-xs-12 col-lg-4">                                            <div class="form-group">                                                <label for="InputName"> اسم العقار</label>                                                <input class="form-control input-height" id="InputName" placeholder=""                                                       type="text">                                            </div>                                        </div>                                        <div class="col-md-4 col-xs-12 col-lg-4">                                            <div class="form-group">                                                <label for="Inputcategory">ايجار / بيع</label>                                                <select class="form-control search-slt" id="category">                                                    <option>ايجار</option>                                                    <option> بيع</option>                                                </select>                                            </div>                                        </div>                                        <div class="col-md-4 col-xs-12 col-lg-4">                                            <div class="form-group">                                                <label for="InputType"> نوع العقار</label>                                                <select class="form-control search-slt" id="InputType">                                                    <option>عقد1</option>                                                    <option> عقد2</option>                                                </select>                                            </div>                                        </div>                                        <div class="col-md-4 col-xs-12 col-lg-4">                                            <div class="form-group">                                                <label for="Region">  المنطقة</label>                                                <select class="form-control search-slt" id="Region">                                                    <option>منظقه1</option>                                                    <option> منظقه2</option>                                                </select>                                            </div>                                        </div>                                        <div class="col-md-4 col-xs-12 col-lg-4">                                            <div class="form-group">                                                <label for="country">المدينة </label>                                                <select class="form-control search-slt" id="country">                                                    <option>مدينه1</option>                                                    <option> مدينه2</option>                                                </select>                                            </div>                                        </div>                                        <div class="col-md-4 col-xs-12 col-lg-4">                                            <div class="form-group">                                                <label for="Region">  الحي</label>                                                <select class="form-control search-slt" id="region">                                                    <option>حي1</option>                                                    <option> حي2</option>                                                </select>                                            </div>                                        </div>                                        <div class="col-md-6 col-xs-12 col-lg-6">                                            <div class="form-group">                                                <label for="InputpriceFrom">    السعر من</label>                                                <input class="form-control" id="InputpriceFrom" placeholder=""                                                       type="text">                                            </div>                                        </div>                                        <div class="col-md-6 col-xs-12 col-lg-6">                                            <div class="form-group">                                                <label for="InputpriceTo">  السعر الي</label>                                                <input class="form-control" id="InputpriceTo" placeholder=""                                                       type="text">                                            </div>                                        </div>                                        <div class="col-md-12 col-xs-12 col-lg-12">                                            <div class="form-group">                                                <label for="inputmessage">  الرسالة </label>                                                <textarea name="inputmessage" rows="2" id="inputmessage" class="form-control" placeholder=""></textarea>                                            </div>                                        </div>                                        <div class="col-md-12 col-xs-12 col-lg-12">                                            <div class="form-group  pd-ask-div">                                                <button class="form-control btn_save" type="submit"> ارسال</button>                                            </div>                                        </div>                                        <!-- .form-group end -->                                    </form>                                </div><!-- .section-title end -->                            </div>                        </div>                    </div>                </div>            </div>            <div class="wrapper">                <div class="container">                    <div class="row">                        <div class="col-md-8 col-md-offset-4 stepper">                        </div>                    </div>                </div>            </div>        </div><!-- #content-wrap -->    </section><!-- #content end -->@endsection