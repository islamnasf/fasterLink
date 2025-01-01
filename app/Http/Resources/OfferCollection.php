<?php

namespace App\Http\Resources;

use App\Http\Shared\ImageService;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'name_en'=>$this->name_en,
            'name_ar'=>$this->name_ar,
            'description_en'=>$this->description_en,
            'description_ar'=>$this->description_ar,
            'days_period'=>$this->days_period,
            'start_date'=>$this->start_date,
            'end_date'=>$this->end_date,
            'active'=>(int)$this->active,
            'image' => ImageService::url($this->image),
            'terms'=>$this->terms,
        ];
    }
}