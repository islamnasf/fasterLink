<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class SharePointCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'code'=>$this->code,
            'points'=>(int)$this->points,
            'store'=>StoreCollection::make($this->store),
        ];
    }
}