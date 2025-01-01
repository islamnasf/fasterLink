<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchWithDistanceCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'name'=>$this->name,
            'phone'=>$this->phone,
            'city'=>CityCollection::make($this->city),
            'address'=>$this->address,
            'lat'=>$this->lat,
            'lng'=>$this->lng,
            'whatsapp'=>$this->whatsapp,
            'distance'=>($this->distance)?round($this->distance,2)*1000:null,
        ];
    }
}