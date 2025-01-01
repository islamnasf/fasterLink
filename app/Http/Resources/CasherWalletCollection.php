<?php

namespace App\Http\Resources;

use App\Http\Shared\RewardType;
use App\Models\Invoice;
use App\Models\Reward;
use App\Models\Wallet;
use Illuminate\Http\Resources\Json\JsonResource;

class CasherWalletCollection extends JsonResource{

    public function toArray($request)
    {
        $casher = auth('user')->user();
        $points_wallet = Wallet::where('store_id',$this->id)->where('user_id',$casher->id)->get();
        $casher_points = $points_wallet->sum('casher_points');
        $casher_expended_points = $points_wallet->sum('casher_expended_points');

        $rewards_wallet = Reward::where('store_id',$this->id)->where('casher_id',$casher->id)->get();
        $rewards = $rewards_wallet->count();
        // $expended_rewards = $rewards_wallet->where('is_used',1)->count();

        // $invoice = Invoice::where('store_id',$this->id)->get();
        // $invoices_count = $invoice->count();
        // $total_invoices = $invoice->sum('total');

        $invoice = Invoice::where('store_id',$this->id)->where('casher_id',$casher->id)->whereNotNull('user_id')->get();
        $invoices_count = $invoice->count();
        $total_invoices = $invoice->sum('total');
        

        return [
            'points_wallet'=>[
                'points'=>(int)$casher_points,
                'expended_points'=>(int)$casher_expended_points,
                'total_points'=>(int)($casher_points+$casher_expended_points),
            ],
            'rewards_wallet'=>[
                'rewards'=>(int)$rewards,
                'reward_type'=> ($this->reward_type)?RewardType::getTypes()[$this->reward_type-1]:null,
                'reward_name' => $this->reward_name,
                // 'expended_rewards'=>(int)$expended_rewards,
                // 'total_rewards'=>(int)($rewards+$expended_rewards),
            ],
            'invoices'=>[
                'invoices_count'=>(int)$invoices_count,
                'total_invoices'=>(float)$total_invoices,
            ],
        ];
    }
}