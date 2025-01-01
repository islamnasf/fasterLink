<?php

namespace App\Http\Resources;

use App\Http\Shared\ImageService;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'rating'=>(int)$this->rating,
            'comment'=>$this->comment,
            'user_name'=>$this->user->name,
            'image'=>ImageService::url($this->user->image),
            'date'=>date('Y-m-d H:i:s',strtotime($this->created_at)),
        ];
    }
}