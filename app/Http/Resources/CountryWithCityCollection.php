<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryWithCityCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'name'=>$this->name_ar,
            'country_code'=>$this->country_code,
            'phone_code'=>$this->phone_code,
            'cities'=>CityCollection::collection($this->cities)
        ];
    }
}