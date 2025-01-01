<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CashbackRequest;
use App\Http\Requests\User\InvoiceSettingsRequest;
use App\Http\Requests\User\LoyaltyRequest;
use App\Http\Resources\CashbackCollection;
use App\Http\Resources\InvoiceSettingsCollection;
use App\Http\Resources\LoyaltyCollection;
use App\Http\Shared\UserRole;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreSettingController extends Controller
{
    //Invoice
    public function getInvoice(Request $request, $id)
    {
        $user = auth('user')->user();
        $store = $user->stores->firstWhere('id', $id);
        if ($store) {
            return successResponse(data: InvoiceSettingsCollection::make($store));
        }
        return failResponse(__('messages.store_not_found'));
    }

    public function updateInvoice(InvoiceSettingsRequest $request)
    {
        $user = auth('user')->user();
        $userStore = $user->userStores->firstWhere('store_id', $request->store_id);
        if ($userStore) {
            if ($userStore->role == UserRole::casher) {
                return failResponse(__('messages.no_permission'));
            }
            $store = Store::find($request->store_id);
            $data = $request->validated();
            $store->update($data);
            return successResponse();
        }
        return failResponse(__('messages.store_not_found'));
    }

    //Cashback
    public function getCashback(Request $request, $id)
    {
        $user = auth('user')->user();
        $store = $user->stores->firstWhere('id', $id);
        if ($store) {
            return successResponse(data: CashbackCollection::make($store));
        }
        return failResponse(__('messages.store_not_found'));
    }

    public function updateCashback(CashbackRequest $request)
    {
        $user = auth('user')->user();
        $userStore = $user->userStores->firstWhere('store_id', $request->store_id);
        if ($userStore) {
            if ($userStore->role == UserRole::casher) {
                return failResponse(__('messages.no_permission'));
            }
            $store = Store::find($request->store_id);
            if ($request->cashback_enabled && $store->loyalty_enabled && $store->loyalty_expired > date('Y-m-d')) {
                return failResponse('The loyalty has not expired yet');
            }
            $data = $request->validated();
            $data['loyalty_enabled'] = 0;
            $data['loyalty_type'] = null;
            $store->update($data);
            return successResponse();
        }
        return failResponse(__('messages.store_not_found'));
    }

    //Loyalty
    public function getLoyalty(Request $request, $id)
    {
        $user = auth('user')->user();
        $store = $user->stores->firstWhere('id', $id);
        if ($store) {
            return successResponse(data: LoyaltyCollection::make($store));
        }
        return failResponse(__('messages.store_not_found'));
    }

    public function updateLoyalty(LoyaltyRequest $request)
    {
        $user = auth('user')->user();
        $userStore = $user->userStores->firstWhere('store_id', $request->store_id);
        if ($userStore) {
            if ($userStore->role == UserRole::casher) {
                return failResponse(__('messages.no_permission'));
            }
            $store = Store::find($request->store_id);
            if ($request->loyalty_type == 'product' && $store->loyalty_type == 'invoice' && $store->loyalty_expired > date('Y-m-d')) {
                return failResponse('The loyalty has not expired yet');
            }
            if ($request->loyalty_type == 'product') {
                $products = [];
                for ($i = 0; $i < $request->loyalty_product_codes; $i++) {
                    $products[] = ['store_id' => $store->id, 'code' => uniqid("pro_")];
                }
                Product::insert($products);
            }
            $data = $request->validated();
            $data['loyalty_expired'] = date('Y-m-d', strtotime("+$request->loyalty_period month"));
            $data['cashback_enabled'] = 0;
            $store->update($data);
            return successResponse();
        }
        return failResponse(__('messages.store_not_found'));
    }
}
