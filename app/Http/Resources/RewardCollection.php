<?php

namespace App\Http\Resources;

use App\Http\Shared\RewardType;
use Illuminate\Http\Resources\Json\JsonResource;

class RewardCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'code'=>$this->code,
            'reward_type_id'=>(int)$this->reward_type,
            'reward_type'=>RewardType::getTypes()[$this->reward_type-1]["name"],//RewardType::getTypes()[$this->reward_type-1]["name"]
            'reward_name'=>$this->reward_name,
            'loyalty_expired'=>$this->store->loyalty_expired,
            'is_valid'=>(int)($this->store->loyalty_expired > date('Y-m-d')),
            'store'=>StoreCollection::make($this->store),
            'is_used'=>(int)$this->is_used,
        ];
    }
}