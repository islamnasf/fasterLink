<?php

namespace App\Http\Resources;

use App\Http\Services\RequestService;
use Illuminate\Http\Resources\Json\JsonResource;

class LinkTypeCollection extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'name' => $this->{'name_' . RequestService::getLanguage()},
        ];
    }
}
