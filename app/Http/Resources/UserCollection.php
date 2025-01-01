<?php

namespace App\Http\Resources;

use App\Http\Shared\ImageService;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'code'=>$this->code,
            'name'=>$this->name,
            'phone'=>$this->phone,
            'email'=>$this->email,
            'image'=>ImageService::url($this->image),
            'points'=>(int)$this->points,
        ];
    }
}