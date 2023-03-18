<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'phone' => $this->phone,
            'facebook' => $this->facebook,
            'telgram' => $this->telgram,
            'whatsApp' => $this->whatsApp,
            'twitter' => $this->twitter,
            'snap' => $this->snap,
//            'companyLogo' => getImageUrl('Setting',$this->companyLogo),
//            'aboutImage' => getImageUrl('Setting',$this->aboutImage),
            'terms' => $request->header('lang') =='en' ?$this->terms_en : $this->terms_ar,
//            'aboutCompany' => $request->header('lang') =='en' ?$this->aboutCompany_en : $this->aboutCompany_ar,
            'about' => $request->header('lang') =='en' ?$this->about_en : $this->about_ar,
            'site' => $this->site,
            'email' => $this->emailD,
            'image' => getImageUrl('Setting',$this->imageD),
        ];
    }
}
