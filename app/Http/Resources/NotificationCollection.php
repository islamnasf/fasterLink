<?php

namespace App\Http\Resources;

use App\Http\Services\TranslationService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Lang;

class NotificationCollection extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'title' => TranslationService::translateTitle($this),
            'body' => TranslationService::translateBody($this),
            'date' => date('Y-m-d h:i:s A', strtotime($this->created_at)),
            'is_read' => (int)$this->is_read,
            'type' => $this->type,
            "$this->type" => ResourceCollectionFactory::create($this->type, $this->relatable),
        ];
    }
}
