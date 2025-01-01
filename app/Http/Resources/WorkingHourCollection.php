<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkingHourCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'day'=>$this->day,
            //'day_name'=> TranslationService::translateDay(RequestService::getLanguage(),$this->day),
            'periods'=>$this->periods,
            'is_working'=>$this->is_working,
        ];
    }
}