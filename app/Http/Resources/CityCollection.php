<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class CityCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'name'=>$this->name_ar,
        ];
    }
}