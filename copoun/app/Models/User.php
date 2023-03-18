<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;


class User extends Authenticatable
{


    use HasApiTokens, Notifiable;

    /***
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function myWishlist(){
        return $this->belongsToMany(Coupon::class,'wishlists','user_id','coupon_id')
            ->where('type',1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function myCoupons(){
        return $this->belongsToMany(Coupon::class,'wishlists','user_id','coupon_id')
            ->where('type',2);
    }

}
