<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'points'=>(int)$this->points,
            'expended_points'=>(int)$this->expended_points,
            'store'=>StoreCollection::make($this->store),
            'total_points'=>(int)($this->points+$this->expended_points),
        ];
    }
}