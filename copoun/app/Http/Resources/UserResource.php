<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'dateOfBirth' => $this->dateOfBirth,
            'active_code' => $this->active_code,
            'password_code' => $this->password_code,
            'status' => (int)$this->status,
            'gender'=>(int)$this->gender,
            'image' => getImageUrl('User',$this->image),
            'country' => $this->country ? new CountryResource($this->country) : null,
            'token' => $this->user_token,
        ];
    }
}
