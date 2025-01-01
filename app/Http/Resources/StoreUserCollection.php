<?php

namespace App\Http\Resources;

use App\Http\Shared\ImageService;
use App\Models\Invoice;
use App\Models\Reward;
use App\Models\Wallet;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreUserCollection extends JsonResource{

    public function toArray($request)
    {
        $points = Wallet::where('store_id',$this->store_id)->where('user_id',$this->user_id)->first()->casher_points??0;
        $rewards_count = Reward::where('store_id',$this->id)->where('casher_id',$this->user_id)->count()??0;
        $invoices_count = Invoice::where('store_id',$this->id)->where('casher_id',$this->user_id)->count()??0;
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
            'points' => (int)$points,
            'rewards_count' => (int)$rewards_count,
            'invoices_count' => (int)$invoices_count,
            'accept' => 1,
        ];
    }
}