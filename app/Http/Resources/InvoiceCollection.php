<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceCollection extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'subtotal' => $this->subtotal,
            'discount' => $this->discount,
            'grand_total' => $this->grand_total,
            'payment_status' => $this->payment_status,
            'country_id' => $this->country_id,
            'multi_branches' => $this->multi_branches,
        ];
    }
}
