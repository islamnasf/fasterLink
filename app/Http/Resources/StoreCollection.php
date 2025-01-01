<?php

namespace App\Http\Resources;

use App\Http\Shared\ImageService;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreCollection extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'description_en' => $this->description_en,
            'description_ar' => $this->description_ar,
            'username' => $this->username,
            'category_id' => (int)$this->category_id,
            'city_id' => (int)$this->city_id,
            'full_description_en' => $this->full_description_en,
            'full_description_ar' => $this->full_description_ar,
            'logo' => ImageService::url($this->logo),
            'cover_type' => $this->cover_type,
            'cover_images' => ImageService::urls($this->cover_images),
            'cover_video_url' => $this->cover_video_url,
            'multi_branches' => (int)$this->multi_branches,
        ];
    }
}
