<?php

namespace App\Http\Resources;

use App\Http\Shared\ImageService;
use App\Http\Shared\RewardType;
use App\Models\Loyalty;
use Illuminate\Http\Resources\Json\JsonResource;

class MyLoyaltyCollection extends JsonResource{

    public function toArray($request)
    {
        if ($this->store) {
            return [
                'points'=>(int)($this->points??0),
    
                'loyalty_type'=>$this->loyalty_type,
                'loyalty_type_name'=>($this->loyalty_type)?__("messages.$this->loyalty_type"):$this->loyalty_type,
                'loyalty_period'=>(int)$this->store->loyalty_period,
                'loyalty_expired'=>$this->store->loyalty_expired,
                'loyalty_invoice_amount'=>(float)$this->store->loyalty_invoice_amount,
                'loyalty_product_name'=>$this->store->loyalty_product_name,
                'loyalty_product_points'=>(int)$this->store->loyalty_product_points,
                'loyalty_product_codes'=>(int)$this->store->loyalty_product_codes,
                'loyalty_product_points_in_code'=>(int)$this->store->loyalty_product_points_in_code,
                'loyalty_target_points'=>($this->store->loyalty_type == "product")?(int)$this->store->loyalty_product_points:(int)$this->store->loyalty_invoice_amount,
                'only_from_my_store'=>(int)$this->store->only_from_my_store,
                'loyalty_images'=>ImageService::urls($this->store->loyalty_images),
                'reward_type'=> ($this->store->reward_type)?RewardType::getTypes()[$this->store->reward_type-1]:null,
                'reward_name'=>$this->store->reward_name,
                'reward_points'=>(int)$this->store->reward_points,
                'store'=>StoreCollection::make($this->store),
            ];
        }else{

            $points= $this->points??0;

            $user = auth('user')->user();
            if ($user) {
                $points = Loyalty::where('user_id', $user->id)->where('store_id', $this->id)->first()->points ??0;
            }

            return [
                'points'=>(int)($points??0),
    
                'loyalty_type'=>$this->loyalty_type,
                'loyalty_type_name'=>($this->loyalty_type)?__("messages.$this->loyalty_type"):$this->loyalty_type,
                'loyalty_period'=>(int)$this->loyalty_period,
                'loyalty_expired'=>$this->loyalty_expired,
                'loyalty_invoice_amount'=>(float)$this->loyalty_invoice_amount,
                'loyalty_product_name'=>$this->loyalty_product_name,
                'loyalty_product_points'=>(int)$this->loyalty_product_points,
                'loyalty_product_codes'=>(int)$this->loyalty_product_codes,
                'loyalty_product_points_in_code'=>(int)$this->loyalty_product_points_in_code,
                'loyalty_target_points'=>($this->loyalty_type == "product")?(int)$this->loyalty_product_points:(int)$this->loyalty_invoice_amount,
                'only_from_my_store'=>(int)$this->only_from_my_store,
                'loyalty_images'=>ImageService::urls($this->loyalty_images),
                'reward_type'=> ($this->reward_type)?RewardType::getTypes()[$this->reward_type-1]:null,
                'reward_name'=>$this->reward_name,
                'reward_points'=>(int)$this->reward_points,
                'store'=>StoreCollection::make($this),
            ];
        }
       
    }
}