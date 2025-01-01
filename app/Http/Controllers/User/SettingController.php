<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreSettingRequest;
use App\Http\Resources\StoreSettingCollection;
use App\Models\Store;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function index(Request $request)
    {
        $user = auth('user')->user();
        $store = Store::firstWhere('user_id', $user->id);
        if (!$store) {
            return failResponse(__('messages.store_not_found'));
        }
        return successResponse(data: StoreSettingCollection::make($store));
    }

    public function update(StoreSettingRequest $request)
    {
        $user = auth('user')->user();
        $store = Store::where('user_id', $user->id)->first();
        if (!$store) {
            return failResponse(__('messages.store_not_found'));
        }
        $data = $request->validated();
        $store->update($data);
        return successResponse();
    }

}
