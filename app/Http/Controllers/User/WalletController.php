<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\RewardCollection;
use App\Http\Resources\WalletCollection;
use App\Http\Resources\WalletLogCollection;
use App\Models\Reward;
use App\Models\Wallet;
use App\Models\WalletLog;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        $user = auth('user')->user();
        $wallets = Wallet::where('user_id', $user->id);
        $result = $wallets->orderBy('created_at', 'desc')->paginate(10);
        return successResponse(data: WalletCollection::collection($result), pagination: $result);
    }

    public function logs(Request $request,$id)
    {
        $user = auth('user')->user();
        $wallet = Wallet::where('id', $id)->where('user_id', $user->id)->first();
        if ($wallet) {
            $walletLogs = WalletLog::where('store_id', $wallet->store_id)->where('user_id', $user->id)->get();
            return successResponse(data: WalletLogCollection::collection($walletLogs));
        }
        return failResponse(__('messages.wallet_not_found'));
    }

    public function rewards()
    {
        $user = auth('user')->user();
        $rewards = Reward::where('user_id', $user->id);
        $result = $rewards->orderBy('created_at', 'desc')->paginate(10);
        return successResponse(data: RewardCollection::collection($result), pagination: $result);
    }
}
