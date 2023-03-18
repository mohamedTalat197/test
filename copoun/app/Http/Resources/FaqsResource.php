<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $lang=$request->header('lang');

        return [
            'id' => $this->id,
            'question' =>$lang=='ar' ? $this->question_ar : $this->question_en,
            'answer' =>$lang=='ar' ? $this->answer_ar : $this->answer_en,
        ];
    }
}
