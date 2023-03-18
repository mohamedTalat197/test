<div class="card-group">
    <!-- Card -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="m-r-10">
                                    <span class="btn btn-circle btn-lg bg-danger">
                                        <i class="ti-clipboard text-white"></i>
                                    </span>
                </div>
                <div>
                    عدد الكوبونات
                </div>
                <div class="ml-auto">
                    <h2 class="m-b-0 font-light">{{\App\Models\Coupon::count()}}</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Card -->
    <!-- Card -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="m-r-10">
                                    <span class="btn btn-circle btn-lg btn-info">
                                        <i class="ti-wallet text-white"></i>
                                    </span>
                </div>
                <div>
                    عدد البلاد

                </div>
                <div class="ml-auto">
                    <h2 class="m-b-0 font-light">{{\App\Models\Country::count()}}</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Card -->
    <!-- Card -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="m-r-10">
                                    <span class="btn btn-circle btn-lg bg-success">
                                        <i class=" icon-Duplicate-Layer text-white"></i>
                                    </span>
                </div>
                <div>
                    عدد الاقسام

                </div>
                <div class="ml-auto">
                    <h2 class="m-b-0 font-light">{{\App\Models\Category::count()}}</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Card -->
    <!-- Card -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="m-r-10">
                                    <span class="btn btn-circle btn-lg bg-warning">
                                        <i class="fa fa-user text-white"></i>
                                    </span>
                </div>
                <div>
                    عدد الاعضاء

                </div>
                <div class="ml-auto">
                    <h2 class="m-b-0 font-light">{{\App\Models\User::count()}}</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Card -->
    <!-- Column -->


</div>
