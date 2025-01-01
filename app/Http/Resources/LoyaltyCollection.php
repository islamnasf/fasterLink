<?php

namespace App\Http\Resources;

use App\Http\Shared\ImageService;
use App\Http\Shared\RewardType;
use Illuminate\Http\Resources\Json\JsonResource;

class LoyaltyCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'loyalty_enabled'=>(int)$this->loyalty_enabled,
            'loyalty_type'=>$this->loyalty_type,
            'loyalty_type_name'=>($this->loyalty_type)?__("messages.$this->loyalty_type"):$this->loyalty_type,
            'loyalty_period'=>(int)$this->loyalty_period,
            'loyalty_expired'=>$this->loyalty_expired,
            'loyalty_invoice_amount'=>(float)$this->loyalty_invoice_amount,
            'loyalty_product_name'=>$this->loyalty_product_name,
            'loyalty_product_points'=>(int)$this->loyalty_product_points,
            'loyalty_product_codes'=>(int)$this->loyalty_product_codes,
            'loyalty_product_points_in_code'=>(int)$this->loyalty_product_points_in_code,
            'only_from_my_store'=>(int)$this->only_from_my_store,
            'loyalty_images'=>ImageService::urls($this->loyalty_images),
            'reward_type'=> ($this->reward_type)?RewardType::getTypes()[$this->reward_type-1]:null,
            'reward_name'=>$this->reward_name,
            'reward_points'=>(int)$this->reward_points,
            'coding_type' =>$this->coding_type,
        ];
    }
}