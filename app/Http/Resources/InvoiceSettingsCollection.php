<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceSettingsCollection extends JsonResource
{

    public function toArray($request)
    {
        return [
            'is_electronic_invoice' => (int)$this->is_electronic_invoice,
            'is_invoice_coding' => (int)$this->is_invoice_coding,
            'is_invoice_has_code' => (int)$this->is_invoice_has_code,
            'coding_type' => $this->coding_type,
            'tax_number' => $this->tax_number,
        ];
    }
}
