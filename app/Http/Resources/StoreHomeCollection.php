<?php

namespace App\Http\Resources;

use App\Http\Shared\ImageService;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreHomeCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'logo'=>ImageService::url($this->logo),
            'cover'=>ImageService::url($this->cover),
            'brand_name'=>$this->brand_name,
            'business_description'=>$this->business_description,
            'category'=>CategoryCollection::make($this->category),
            'facebook'=>$this->facebook,
            'instagram'=>$this->instagram,
            'snapchat'=>$this->snapchat,
            'twitter'=>$this->twitter,
            'youtube'=>$this->youtube,
            'website'=>$this->website,
            'branches'=>BranchWithDistanceCollection::collection($this->branches),
            'departments'=>DepartmentCollection::collection($this->departments),
            'points_enabled'=>(int)($this->loyalty_enabled||$this->cashback_enabled),
            'loyalty_enabled'=>(int)$this->loyalty_enabled,
            'cashback_enabled'=>(int)$this->cashback_enabled,
            "ratings_avg" => (float)round($this->ratings_avg_rating, 2),
            // 'distance'=>$this->distance,
        ];
    }
}