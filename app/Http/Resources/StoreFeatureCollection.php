<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreFeatureCollection extends JsonResource
{
    public function toArray($request)
    {
        return [
            'effect_button' => $this->effect_button,
            'introduction_screen' => $this->introduction_screen,
            'ad_bar' => $this->ad_bar,
            'background_image' => $this->background_image,
        ];
    }
}
