<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class CashbackCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'cashback_enabled'=>(int)$this->cashback_enabled,
            'cashback_percentage'=>(float)$this->cashback_percentage,
            'coding_type' =>$this->coding_type,
        ];
    }
}