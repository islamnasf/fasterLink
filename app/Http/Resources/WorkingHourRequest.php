<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'name_en'=>$this->name_en,
            'name_ar'=>$this->name_ar,
            'city_id'=>$this->city_id,
            'location'=>$this->location,
            'address_en'=>$this->address_en,
            'address_ar'=>$this->address_ar,
            'is_main'=>$this->is_main,
        ];
    }
}