<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreRequestCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->id,
            'role'=>$this->role,
            'role_name'=>__("messages.".$this->role),
            'store'=>StoreCollection::make($this->store),
            'branch' => BranchCollection::make($this->branch)
        ];
    }
}