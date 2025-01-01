<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchNumberCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'name_en'=>$this->name_en,
            'name_ar'=>$this->name_ar,
            'type'=>$this->type,
            'number'=>$this->number,
        ];
    }
}