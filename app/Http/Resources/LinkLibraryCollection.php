<?php

namespace App\Http\Resources;

use App\Http\Services\RequestService;
use App\Http\Shared\ImageService;
use Illuminate\Http\Resources\Json\JsonResource;

class LinkLibraryCollection extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'name' => $this->{'name_' . RequestService::getLanguage()},
            'image' => ImageService::url($this->image),
        ];
    }
}
