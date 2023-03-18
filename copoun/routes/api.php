<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
use Illuminate\Http\Request;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *');

header('Content-Type: application/json; charset=UTF-8', true);


/** Start Auth Route **/

Route::middleware('auth:api')->group(function () {
    //Auth_private
    Route::prefix('Auth_private')->group(function()
    {
        Route::post('/change_password', 'UserController@change_password');
        Route::post('/edit_profile', 'UserController@edit_profile');
        Route::post('/check_password_code', 'UserController@check_password_code');
        Route::post('/check_active_code', 'UserController@check_active_code');
        Route::get('/my_info', 'UserController@my_info');
        Route::post('/reset_password', 'UserController@reset_password');
        Route::post('/logout', 'UserController@logout');
        Route::post('/resend_code', 'UserController@resend_code');
        Route::post('/change_lang', 'UserController@change_lang');
    });

    /** Coupon */
    Route::prefix('Coupon')->group(function()
    {
        Route::post('/rate', 'CouponController@rate');
        Route::post('/addToWishlist', 'CouponController@addToWishlist');
        Route::post('/addToMyCoupons', 'CouponController@addToMyCoupons');
        Route::post('/addCoupon', 'CouponController@addCoupon');
        Route::post('/unActiveOrActive', 'CouponController@unActiveOrActive');
        Route::get('/myWishlist', 'CouponController@myWishlist');
        Route::get('/myCoupons', 'CouponController@myCoupons');
    });


});
/** End Auth Route **/

/** Auth_general */
Route::prefix('Auth_general')->group(function()
{
    Route::post('/register', 'UserController@register');
    Route::post('/login', 'UserController@login');
    Route::post('/forget_password', 'UserController@forget_password');
});

/** General */
Route::prefix('General')->group(function()
{
    Route::get('/countries', 'GeneralController@countries');
    Route::get('/categories', 'GeneralController@categories');
    Route::get('/aboutApp', 'GeneralController@aboutApp');
    Route::get('/developers', 'GeneralController@developers');
    Route::get('/Faqs', 'GeneralController@Faqs');
    Route::post('/contactUs', 'GeneralController@contactUs');
});

/** Coupon */
Route::prefix('Coupon')->group(function()
{
    Route::get('/coupons', 'CouponController@coupons');
    Route::get('/single', 'CouponController@single');
});
