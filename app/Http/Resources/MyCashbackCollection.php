<?php

namespace App\Http\Resources;

use App\Models\Wallet;
use Illuminate\Http\Resources\Json\JsonResource;

class MyCashbackCollection extends JsonResource
{

    public function toArray($request)
    {
        $user = auth('user')->user();
        $wallet = null;
        if ($this->store) {
            if ($user) {
                $wallet = Wallet::where('store_id', $this->store->id)->where('user_id', $user->id)->first();
            }
            return [
                'cashback_percentage' => (float)($this->store->cashback_percentage ?? 0),
                'store' => StoreCollection::make($this->store),
                'wallet' => $wallet ? WalletCachbackCollection::make($wallet) : null,
            ];
        } else {
            if ($user) {
                $wallet = Wallet::where('store_id', $this->id)->where('user_id', $user->id)->first();
            }
            return [
                'cashback_percentage' => (float)($this->cashback_percentage ?? 0),
                'store' => StoreCollection::make($this),
                'wallet' => $wallet ? WalletCachbackCollection::make($wallet) : null,
            ];
        }
    }
}
