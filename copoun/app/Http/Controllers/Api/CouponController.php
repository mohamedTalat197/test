<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CouponCollection;
use App\Http\Resources\CouponResource;
use App\Http\Resources\RateResource;
use App\Models\Coupon;
use App\Models\Wishlist;
use App\Reposatries\RateRepo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Auth,Artisan,Hash,File,Crypt;

class CouponController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function coupons(Request $request){
        $coupons=Coupon::orderBy('id','desc')->where('status',1)->whereDate('endDate','>=',now());
        if($request->cat_id)
            $coupons=$coupons->where('cat_id',$request->cat_id);
        if($request->country_id)
            $coupons=$coupons->where('country_id',$request->country_id);
        $coupons=$coupons->paginate(10);
        $specialCoupons=Coupon::orderBy('id','desc')->where('isSpecial',1)->paginate(10);
        $data=['coupons'=>new CouponCollection($coupons),'specialCoupons'=>new CouponCollection($specialCoupons)];
        return $this->apiResponseData($data,'success');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function single(Request $request){
        $coupon=Coupon::where('id',$request->coupon_id)->firstOrFail();
        $data=['coupon'=>new CouponResource($coupon),'rates'=>RateResource::collection($coupon->rateRelation)];
        return $this->apiResponseData($data,'success');
    }

    /***
     * @param Request $request
     * @param RateRepo $rateRepo
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function rate(Request $request,RateRepo $rateRepo){
        $Coupon=Coupon::findOrFail($request->coupon_id);
        return $rateRepo->rating('App\Models\Coupon',$request,$Coupon);
    }

    /****
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function addToWishlist(Request $request){
        $Coupon=Coupon::findOrFail($request->coupon_id);
        $lang=$request->header('lang');
        $user=Auth::user();
        $wishlist=Wishlist::where('user_id',$user->id)->where('type',1)->where('coupon_id',$request->coupon_id)->first();
        if(is_null($wishlist)){
            $wishlist=new Wishlist();
            $wishlist->user_id=$user->id;
            $wishlist->coupon_id=$request->coupon_id;
            $wishlist->type=1;
            $wishlist->save();
            $msg=$lang=='ar' ? 'تم اضافة الكوبون الي المفضلة' : 'The coupon has been added to your favourites';
        }else{
            $wishlist->delete();
            $msg=$lang=='ar' ? 'تم ازالة الكوبون من المفضلة' : 'Coupon removed from favourites';
        }
        return $this->apiResponseData(CouponResource::collection($user->myWishlist),$msg);
    }

    /***
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function addToMyCoupons(Request $request){
        $Coupon=Coupon::findOrFail($request->coupon_id);
        $lang=$request->header('lang');
        $user=Auth::user();
        $wishlist=Wishlist::where('user_id',$user->id)->where('type',2)->where('coupon_id',$request->coupon_id)->first();
        if(is_null($wishlist)){
            $wishlist=new Wishlist();
            $wishlist->user_id=$user->id;
            $wishlist->coupon_id=$request->coupon_id;
            $wishlist->type=2;
            $wishlist->save();
        }
        $msg=$lang=='ar' ? 'تم اضافة الكوبون ' : 'The coupon has been added ';
        return $this->apiResponseData(CouponResource::collection($user->myCoupons),$msg);
    }

    /***
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function unActiveOrActive(Request $request){
        $Coupon=Coupon::findOrFail($request->coupon_id);
        $lang=$request->header('lang');
        $user=Auth::user();
        if($request->type ==1)
            $Coupon->activeCount+=1;
        if($request->type ==2)
            $Coupon->unActiveCount+=1;
        $Coupon->save();
        $msg=$lang=='ar' ? 'تم التبليغ بنحاج ' : 'Successfully reported ';
        return $this->apiResponseData(CouponResource::collection($user->myCoupons),$msg);

    }

    /***
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function myWishlist(){
        $user=Auth::user();
        return $this->apiResponseData(CouponResource::collection($user->myWishlist),'success');
    }

    public function myCoupons(){
        $user=Auth::user();
        return $this->apiResponseData(CouponResource::collection($user->myCoupons),'success');
    }

    /***
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function addCoupon(Request $request){
        $coupon=new Coupon();
        $coupon->storeName=$request->storeName;
        $coupon->link=$request->link;
        $coupon->name=$request->name;
        $coupon->code=$request->code;
        $coupon->description=$request->description;
        $coupon->cat_id=$request->cat_id;
        $coupon->endDate=$request->endDate;
        $coupon->country_id=Auth::user()->country_id;
        $coupon->user_id=Auth::user()->id;
        $coupon->status=2;
        if($request->storeLogo)
            $coupon->storeLogo=saveImage('Coupon',$request->storeLogo);
        $coupon->save();
        $msg=$request->header('lang') =='ar' ? 'تم اضافة الكوبون..بانتظار موافقة الادارة' :'Coupon added..waiting for approval';
        return $this->apiResponseData(new CouponResource($coupon),$msg);
    }
}
