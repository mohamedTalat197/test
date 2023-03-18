<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class CategoryResource extends JsonResource
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
            'image' => getImageUrl('Category',$this->image),
            'name' => $request->header('lang') =='en' ?$this->name_en : $this->name_ar,
        ];
    }
}
