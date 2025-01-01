<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreSettingCollection extends JsonResource
{
    public function toArray($request)
    {
        return [
            'default_page' => $this->default_page,
            'products_show_method' => $this->products_show_method,
            'identity_color' => $this->identity_color,
            'ratings_active' => $this->ratings_active,
            'views_active' => $this->views_active,
        ];
    }
}
