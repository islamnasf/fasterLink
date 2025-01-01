<?php

namespace App\Http\Resources;

use App\Http\Shared\ImageService;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreLoyaltyUsersCollection extends JsonResource{

    public function toArray($request)
    {
            return [
                'points'=>(int)($this->points??0),
                'user_name'=>$this->user->name,
                'image'=>ImageService::url($this->user->image),
                'loyalty_target_points'=>($this->store->loyalty_type == "product")?(int)$this->store->loyalty_product_points:(int)$this->store->loyalty_invoice_amount,
            ];
    }
}