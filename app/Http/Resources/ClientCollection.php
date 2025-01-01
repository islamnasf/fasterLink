<?php

namespace App\Http\Resources;

use App\Http\Shared\ImageService;
use App\Models\Invoice;
use App\Models\Reward;
use App\Models\Wallet;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientCollection extends JsonResource{

    public function toArray($request)
    {
        $store_id = $this->store_id;

        $invoice = Invoice::where('store_id',$store_id)->where('user_id',$this->id)->get();
        $invoices_count = $invoice->count();
        $total_invoices = $invoice->sum('total');
        $last_invoice_date = $invoice->sortByDesc('invoice_date')->first()->invoice_date??null;
        
        $points_wallet = Wallet::where('store_id',$store_id)->where('user_id',$this->id)->get();
        $points = $points_wallet->sum('points');

        $rewards_wallet = Reward::where('store_id',$store_id)->where('user_id',$this->id)->get();
        $rewards = $rewards_wallet->count();

        return [
            'id'=>(int)$this->id,
            'code'=>$this->code,
            'name'=>$this->name,
            'phone'=>$this->phone,
            'email'=>$this->email,
            'image'=>ImageService::url($this->image),

            'total_invoices'=>(float)$total_invoices,
            'invoices_count'=>(int)$invoices_count,
            'last_invoice_date'=>$last_invoice_date,
            'points'=>(int)$points,
            'rewards'=>(int)$rewards,
        ];
    }


}