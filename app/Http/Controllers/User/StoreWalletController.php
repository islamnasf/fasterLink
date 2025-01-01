<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\CasherWalletCollection;
use App\Http\Resources\StoreWalletCollection;
use App\Http\Resources\StoreWalletPointsCollection;
use App\Http\Resources\StoreWalletUsersCollection;
use App\Http\Shared\UserRole;
use App\Models\Wallet;
use App\Models\WalletLog;
use Illuminate\Http\Request;

class StoreWalletController extends Controller
{
    public function wallets(Request $request,$id)
    {
        $admin = auth('user')->user();
        $store = $admin->stores->where('id', $id)->first();
        if ($store) {
            return successResponse(data: StoreWalletCollection::make($store));
        }
        return failResponse(__('messages.store_not_found'));
    }

    public function casherWallets(Request $request,$id)
    {
        $admin = auth('user')->user();
        $store = $admin->stores->where('id', $id)->first();
        if ($store) {
            return successResponse(data: CasherWalletCollection::make($store));
        }
        return failResponse(__('messages.store_not_found'));
    }

    public function walletPoints(Request $request,$id)
    {
        $admin = auth('user')->user();
        $userStore = $admin->userStores->where('store_id', $id)->first();
        if ($userStore) {
            if ($userStore->role == UserRole::admin) {
                $walletLog = WalletLog::where('store_id',$userStore->store_id)->get();
            }else {
                $walletLog = WalletLog::where('store_id',$userStore->store_id)->where('casher_id',$admin->id)->get();
            }
            return successResponse(data: StoreWalletPointsCollection::collection($walletLog));
        }
        return failResponse(__('messages.store_not_found'));
    }

    public function usersWallets(Request $request,$id)
    {
        $admin = auth('user')->user();
        $userStore = $admin->userStores->where('store_id', $id)->first();
        if ($userStore) {
            $wallets = Wallet::where('store_id',$userStore->store_id)->get();
            return successResponse(data: StoreWalletUsersCollection::collection($wallets));
        }
        return failResponse(__('messages.store_not_found'));
    }
    
}