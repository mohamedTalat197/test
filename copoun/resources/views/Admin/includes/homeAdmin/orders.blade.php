@php
$orders=\App\Models\Coupon::orderBy('id','desc')->whereHas('user')->take(7)->get();
@endphp
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <!-- title -->
                <div class="d-md-flex align-items-center">
                    <div>
                        <h4 class="card-title">اخر الكوبونات</h4>
                        <h5 class="card-subtitle">اخر الكوبونات بواسطة العملاء</h5>
                    </div>

                </div>
                <!-- title -->
            </div>
            <div class="table-responsive">
                <table class="table v-middle">
                    <thead>
                    <tr class="bg-light">
                        <th class="border-top-0">العميل</th>
                        <th class="border-top-0">اسم المتجر</th>
                        <th class="border-top-0">اسم الكود</th>
                        <th class="border-top-0">الكود</th>
                        <th class="border-top-0">البلد</th>
                        <th class="border-top-0">القسم</th>
                        <th class="border-top-0">التاريخ</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $row)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="m-r-10">
                                    <a class="btn btn-circle btn-success text-white">{{$row->id}}</a>
                                </div>
                                <div class="">
                                    <h4 class="m-b-0 font-16">{{$row->user->name}}</h4>
                                </div>
                            </div>
                        </td>
                        <td>{{$row->storeName}}</td>
                        <td>{{$row->name}}</td>

                        <td>{{$row->code}}</td>
                        <td>{{$row->country ? $row->country->name_ar : ''}}</td>
                        <td>
                            <h5 class="m-b-0">{{$row->cat ? $row->cat->name_ar : ''}}</h5>
                        </td>
                        <td>
                            <label class="label label-info ">{{$row->created_at}} </label>
                        </td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

