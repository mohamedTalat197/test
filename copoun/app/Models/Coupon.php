<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    /***
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }

    /***
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cat(){
        return $this->belongsTo(Category::class,'cat_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function rateRelation()
    {
        return $this->morphToMany(User::class,'RateRelation','rates')
            ->withPivot('rate','comment','created_at','updated_at','id')->orderBy('id','desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function myUsers(){
        return $this->belongsToMany(User::class,'wishlists','coupon_id','user_id')
            ->where('type',1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
