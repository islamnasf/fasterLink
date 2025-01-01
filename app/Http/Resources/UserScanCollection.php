<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class UserScanCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'code'=>$this->code,
            'points'=>($this->invoice_date)?(int)$this->points:(int)$this->store->loyalty_product_points_in_code,
            'points_type'=>($this->points_type)?$this->points_type:"loyalty",//__("messages.
            'points_type_name'=>($this->points_type)?__("messages.".$this->points_type):__("messages.loyalty"),//
            'points_source'=>($this->invoice_date)?"invoice":"product",//__("messages.invoice"):__("messages.product")
            'points_source_name'=>($this->invoice_date)?__("messages.invoice"):__("messages.product"),
            'cashback_percentage'=>(float)$this->cashback_percentage,
            'loyalty_target_points'=>($this->store->loyalty_type == "product")?(int)$this->store->loyalty_product_points:(int)$this->store->loyalty_invoice_amount,
            'total'=>(float)$this->total,
        ];
    }
}