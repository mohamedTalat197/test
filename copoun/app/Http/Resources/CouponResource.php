<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $is_fav=false;
        $user = auth('api')->user();
        if ($user) {
            $is_fav = $this->myUsers->contains($user->id);
        }
        return [
            'id' => $this->id,
            'is_fav' => $is_fav,
            'storeName' => $this->storeName,
            'endDate' => $this->endDate,
            'storeLogo' => getImageUrl('Coupon',$this->storeLogo),
            'name' => $this->name,
            'link' => $this->link,
            'code' => $this->code,
            'description' => $this->description,
            'status' => (int)$this->status,
            'isSpecial' => (int)$this->isSpecial,
            'rate' => (int)$this->rate,
            'category' => $this->cat ? new CategoryResource($this->cat) : null,
            'country' => $this->country ? new CountryResource($this->country) : null,
        ];
    }
}
