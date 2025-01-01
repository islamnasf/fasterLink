<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserLoyaltyPointsCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'points'=>(int)$this->points,
            'type'=>$this->type,
            'type_name'=>__("messages.".$this->type),
            'date'=>date('Y-m-d',strtotime($this->created_at)),
        ];
    }
}