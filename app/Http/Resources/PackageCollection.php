<?php

namespace App\Http\Resources;

use App\Http\Services\RequestService;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageCollection extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'name' => $this->{"name_" . RequestService::getLanguage()},
            'basic_price' => $this->basic_price,
            'multi_branches_price' => $this->multi_branches_price,
            'type' => $this->type,
        ];
    }
}
