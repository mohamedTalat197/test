<?php

Route::post('/admin/login', 'AuthController@login')->name('admin.login');

Route::prefix('Admin')->group(function () {
    Route::get('/login', function () {
        return view('Admin.loginAdmin');
    });
    Route::group(['middleware' => 'roles', 'roles' => ['Admin']], function () {

        Route::get('/logout/logout', 'AuthController@logout')->name('user.logout');
        Route::get('/home', 'AuthController@index')->name('admin.dashboard');

        // Profile Route
        Route::prefix('profile')->group(function () {
            Route::get('/index', 'profileController@index')->name('profile.index');
            Route::post('/index', 'profileController@update')->name('profile.update');
        });

        // Category Routes
        Route::prefix('Category')->group(function () {
            Route::get('/index', 'CategoryController@index')->name('Category.index');
            Route::get('/allData', 'CategoryController@allData')->name('Category.allData');
            Route::post('/create', 'CategoryController@create')->name('Category.create');
            Route::get('/edit/{id}', 'CategoryController@edit')->name('Category.edit');
            Route::post('/update', 'CategoryController@update')->name('Category.update');
            Route::get('/destroy/{id}', 'CategoryController@destroy')->name('Category.destroy');
        });

        // Color Routes
        Route::prefix('Country')->group(function () {
            Route::get('/index', 'CountryController@index')->name('Country.index');
            Route::get('/allData', 'CountryController@allData')->name('Country.allData');
            Route::post('/create', 'CountryController@create')->name('Country.create');
            Route::get('/edit/{id}', 'CountryController@edit')->name('Country.edit');
            Route::post('/update', 'CountryController@update')->name('Country.update');
            Route::get('/destroy/{id}', 'CountryController@destroy')->name('Country.destroy');
        });

        /** Developer Roue */
        Route::prefix('Developer')->group(function () {
            Route::get('/index', 'DeveloperController@index')->name('Developer.index');
            Route::get('/allData', 'DeveloperController@allData')->name('Developer.allData');
            Route::post('/create', 'DeveloperController@create')->name('Developer.create');
            Route::get('/edit/{id}', 'DeveloperController@edit')->name('Developer.edit');
            Route::post('/update', 'DeveloperController@update')->name('Developer.update');
            Route::get('/destroy/{id}', 'DeveloperController@destroy')->name('Developer.destroy');
        });

        /** User Route */
        Route::prefix('User')->group(function () {
            Route::get('/index', 'UserController@index')->name('User.index');
            Route::get('/allData', 'UserController@allData')->name('User.allData');
            Route::post('/create', 'UserController@create')->name('User.create');
            Route::get('/edit/{id}', 'UserController@edit')->name('User.edit');
            Route::post('/update', 'UserController@update')->name('User.update');
            Route::get('/destroy/{id}', 'UserController@destroy')->name('User.destroy');
            Route::get('/ChangeStatus/{id}', 'UserController@ChangeStatus')->name('User.ChangeStatus');
        });

        /** Coupon Route */
        Route::prefix('Coupon')->group(function () {
            Route::get('/index', 'CouponController@index')->name('Coupon.index');
            Route::get('/allData', 'CouponController@allData')->name('Coupon.allData');
            Route::post('/create', 'CouponController@create')->name('Coupon.create');
            Route::get('/edit/{id}', 'CouponController@edit')->name('Coupon.edit');
            Route::post('/update', 'CouponController@update')->name('Coupon.update');
            Route::get('/destroy/{id}', 'CouponController@destroy')->name('Coupon.destroy');
            Route::get('/ChangeStatus/{id}', 'CouponController@ChangeStatus')->name('Coupon.ChangeStatus');
        });

        /** Rate Route */
        Route::prefix('Rate')->group(function () {
            Route::get('/index', 'RateController@index')->name('Rate.index');
            Route::get('/allData', 'RateController@allData')->name('Rate.allData');
            Route::post('/create', 'RateController@create')->name('Rate.create');
            Route::get('/edit/{id}', 'RateController@edit')->name('Rate.edit');
            Route::post('/update', 'RateController@update')->name('Rate.update');
            Route::get('/destroy/{id}', 'RateController@destroy')->name('Rate.destroy');
            Route::get('/ChangeStatus/{id}', 'RateController@ChangeStatus')->name('Rate.ChangeStatus');
        });

        /** Question Route */
        Route::prefix('Question')->group(function () {
            Route::get('/index', 'QuestionController@index')->name('Question.index');
            Route::get('/allData', 'QuestionController@allData')->name('Question.allData');
            Route::post('/create', 'QuestionController@create')->name('Question.create');
            Route::get('/edit/{id}', 'QuestionController@edit')->name('Question.edit');
            Route::post('/update', 'QuestionController@update')->name('Question.update');
            Route::get('/destroy/{id}', 'QuestionController@destroy')->name('Question.destroy');
        });

        //Setting Routes
        Route::prefix('Setting')->group(function () {
            Route::get('/index', 'SettingController@index')->name('Setting.index');
            Route::get('/allData', 'SettingController@allData')->name('Setting.allData');
            Route::get('/edit/{id}', 'SettingController@edit')->name('Setting.edit');
            Route::post('/update', 'SettingController@update')->name('Setting.update');
        });

        /** Contact Route */
        Route::prefix('Contact')->group(function () {
            Route::get('/index', 'ContactController@index')->name('Contact.index');
            Route::get('/show', 'ContactController@show')->name('Contact.show');
            Route::get('/allData', 'ContactController@allData')->name('Contact.allData');
            Route::post('/create', 'ContactController@create')->name('Contact.create');
            Route::get('/destroy/{id}', 'ContactController@destroy')->name('Contact.destroy');
        });

        /** Notification  */
        Route::prefix('Notification')->group(function () {
            Route::get('/index', 'NotificationController@index')->name('Notification.index');
            Route::get('/allData', 'NotificationController@allData')->name('Notification.allData');
            Route::get('/destroy/{id}', 'NotificationController@destroy')->name('Notification.destroy');
            Route::post('/create', 'NotificationController@create')->name('Notification.create');
        });
    });
});

