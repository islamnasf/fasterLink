<?php

namespace App\Http\Resources;

use App\Http\Shared\ImageService;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreUserRequestCollection extends JsonResource{

    public function toArray($request)
    {
        return [
            'id'=>(int)$this->user->id,
            'code'=>$this->user->code,
            'name'=>$this->user->name,
            'phone'=>$this->user->phone,
            'email'=>$this->user->email,
            'image'=>ImageService::url($this->user->image),
            'role'=>$this->role,
            'role_name'=>__("messages.".$this->role),
            'branch' => BranchCollection::make($this->branch),
            'points' => null,
            'rewards_count' => null,
            'invoices_count' => null,
            'accept' => 0,
        ];
    }
}