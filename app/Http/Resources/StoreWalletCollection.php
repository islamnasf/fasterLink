<?php

namespace App\Http\Resources;

use App\Http\Shared\PointsType;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Reward;
use App\Models\SharePoint;
use App\Models\Wallet;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreWalletCollection extends JsonResource{

    public function toArray($request)
    {
        $points_wallet = Wallet::where('store_id',$this->id)->get();
        
        $share_points = SharePoint::where('store_id',$this->id)->sum('points');
        $points = $points_wallet->sum('points') + $share_points;

        $expended_points = $points_wallet->sum('casher_points');

        $rewards_wallet = Reward::where('store_id',$this->id)->get();
        $rewards = $rewards_wallet->where('is_used',0)->count();
        $expended_rewards = $rewards_wallet->where('is_used',1)->count();

        $invoice = Invoice::where('store_id',$this->id)->whereNotNull('user_id')->get();
        $invoices_count = $invoice->count();
        $total_invoices = $invoice->sum('total');
        
        $products_count = Product::where('store_id',$this->id)->whereNotNull('user_id')->count();
        $total_loyalty = Invoice::where('store_id',$this->id)->where('points_type',PointsType::loyalty)->whereNotNull('user_id')->sum('total');

        return [
            'points_wallet'=>[
                'points'=>(int)$points,
                'expended_points'=>(int)$expended_points,
                'total_points'=>(int)($points+$expended_points),
            ],
            'rewards_wallet'=>[
                'rewards'=>(int)$rewards,
                'expended_rewards'=>(int)$expended_rewards,
                'total_rewards'=>(int)($rewards+$expended_rewards),

                'products_count'=>(int)$products_count,
                'total_loyalty'=>(float)$total_loyalty,
            ],
            'invoices'=>[
                'invoices_count'=>(int)$invoices_count,
                'total_invoices'=>(float)$total_invoices,
            ],
        ];
    }
}