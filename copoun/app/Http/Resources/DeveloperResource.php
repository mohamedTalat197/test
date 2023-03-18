<?php

namespace App\Http\Resources;

use App\Models\Setting;
use Illuminate\Http\Resources\Json\JsonResource;

class DeveloperResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $setting=Setting::first();
        return [
            'email' => $setting->emailD,
            'image' => getImageUrl('Setting',$setting->imageD),
            'phone' => $setting->phoneD,
        ];
    }
}
