<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'name_en'=>$this->name_en,
            'name_ar'=>$this->name_ar,
        ];
    }
}