<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductSalesCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'name'=>$this->store->loyalty_product_name,
            'points'=>(int)$this->store->loyalty_product_points_in_code,
            'date'=>date('Y-m-d H:i:s',strtotime($this->updated_at)),
        ];
    }
}