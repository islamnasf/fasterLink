<?php

namespace App\Http\Resources;

use App\Http\Shared\ImageService;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreLoyaltyPointsCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'user_name'=>$this->user->name,
            'image'=>ImageService::url($this->user->image),
            'points'=>(int)$this->points,
            'points_source'=>$this->type,
            'points_source_name'=>__("messages.".$this->type),
            'date'=>date('Y-m-d',strtotime($this->created_at)),
        ];
    }
}