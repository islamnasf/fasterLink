<?php

namespace App\Http\Resources;

use App\Http\Shared\ImageService;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreWalletPointsCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'user_name'=>$this->user->name,
            'image'=>ImageService::url($this->user->image),
            'points'=>(int)$this->points,
            'previous_points'=>(int)$this->previous_points,
            'type'=>$this->type,
            'type_name'=> __("messages.".$this->type),
            'points_source'=>$this->points_source,
            'points_source_name'=> __("messages.".$this->points_source),
            'date'=>date('Y-m-d',strtotime($this->created_at)),
        ];
    }
}