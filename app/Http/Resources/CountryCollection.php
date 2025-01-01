<?php

namespace App\Http\Resources;

use App\Http\Services\RequestService;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryCollection extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'name' => $this->{"name_" . RequestService::getLanguage()},
            'country_code' => $this->country_code,
            'phone_code' => $this->phone_code,
        ];
    }
}
