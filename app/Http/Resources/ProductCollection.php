<?php

namespace App\Http\Resources;

use App\Http\Shared\ImageService;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'name_en'=>$this->name_en,
            'name_ar'=>$this->name_ar,
            'description_en'=>$this->description_en,
            'description_ar'=>$this->description_ar,
            'basic_price'=>$this->basic_price,
            'discount'=>$this->discount,
            'price'=>$this->price,
            'image' => ImageService::url($this->image),
            'attributes'=>$this->attributes,
            'active'=>(int)$this->active,
        ];
    }
}