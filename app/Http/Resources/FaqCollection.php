<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class FaqCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'question'=> $this->{"question_".app()->getLocale()},
            'answer'=> $this->{"answer_".app()->getLocale()},
        ];
    }
}