<?php

namespace App\Http\Resources;

use App\Http\Shared\ImageService;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreWithRoleCollection extends JsonResource
{

    public function toArray($request)
    {
        $pointsType = null;
        if ($this->store->loyalty_enabled) {
            $pointsType = 'loyalty';
        }
        if ($this->store->cashback_enabled) {
            $pointsType = 'cashback';
        }
        return [
            'id' => (int)$this->store_id,
            'logo' => ImageService::url($this->store->logo),
            'cover' => ImageService::url($this->store->cover),
            'brand_name' => $this->store->brand_name,
            'business_description' => $this->store->business_description,
            'category' => CategoryCollection::make($this->store->category),
            'facebook' => $this->store->facebook,
            'instagram' => $this->store->instagram,
            'snapchat' => $this->store->snapchat,
            'twitter' => $this->store->twitter,
            'youtube' => $this->store->youtube,
            'website' => $this->store->website,
            'branches' => BranchCollection::collection($this->store->branches),
            'departments' => DepartmentCollection::collection($this->store->departments),
            'role' => $this->role,
            'points_enabled' => (int)($this->store->loyalty_enabled || $this->store->cashback_enabled),
            'points_type' => $pointsType,
            'points_type_name' => ($pointsType) ? __("messages.$pointsType") : $pointsType,
            'loyalty_type' => $this->store->loyalty_type,
            'loyalty_type_name' => ($this->store->loyalty_type) ? __("messages." . $this->store->loyalty_type) : $this->store->loyalty_type,
            'is_invoice_coding' => ($this->store->is_invoice_coding === null) ? null : (int)$this->store->is_invoice_coding,
            'tax_number' => $this->store->tax_number,
            'coding_type' =>$this->store->coding_type,
            "ratings_avg" => (float)round($this->store->ratings()->average('rating'), 2),
            'active' => (int)$this->store->active,
        ];
    }
}
