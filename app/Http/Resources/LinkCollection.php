<?php

namespace App\Http\Resources;

use App\Http\Shared\ImageService;
use Illuminate\Http\Resources\Json\JsonResource;

class LinkCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'name_en'=>$this->name_en,
            'name_ar'=>$this->name_ar,
            'url'=>$this->url,
            'image' => ImageService::url($this->image),
            'active'=>$this->active,
        ];
    }
}