<?php

namespace App\Http\Resources;

use App\Http\Shared\ImageService;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreWalletUsersCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'user_name'=>$this->user->name,
            'image'=>ImageService::url($this->user->image),
            'points'=>(int)$this->points,
            'expended_points'=>(int)$this->expended_points,
            'total_points'=>(int)($this->points+$this->expended_points),
        ];
    }
}