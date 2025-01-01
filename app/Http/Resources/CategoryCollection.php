<?php

namespace App\Http\Resources;

use App\Http\Shared\ImageService;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'name'=> $this->{"name_".app()->getLocale()},
            'image'=>ImageService::url($this->image),
        ];
    }
}