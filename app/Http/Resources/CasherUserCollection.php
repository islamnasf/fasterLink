<?php

namespace App\Http\Resources;

use App\Http\Shared\ImageService;
use Illuminate\Http\Resources\Json\JsonResource;

class CasherUserCollection extends JsonResource{

    public function toArray($request)
    {

        return [
            'id'=>(int)$this->id,
            'code'=>$this->code,
            'name'=>$this->name,
            'phone'=>$this->phone,
            'email'=>$this->email,
            'image'=>ImageService::url($this->image),

            'points' => $this->points,
            'casher_points' => $this->casher_points,
            'rewards' => $this->rewards,

            'role'=>$this->role,
            'role_name'=>($this->role)?__("messages.".$this->role):"",
            'branch' => $this->branch,
            
            'rewards_count' => $this->rewards_count,
            'invoices_count' => $this->invoices_count,
            'invoices' => $this->invoices,
        ];
    }
}