<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\OfferRequest;
use App\Http\Resources\OfferCollection;
use App\Http\Shared\ImageService;
use App\Models\Offer;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index(Request $request, $id = null)
    {
        $user = auth('user')->user();
        if (!$store = Store::firstWhere('user_id', $user->id)) {
            return failResponse(__('messages.store_not_found'));
        }
        if ($id) {
            $offer = Offer::where('store_id', $store->id)->where('id', $id)->first();
            return successResponse(data: OfferCollection::make($offer));
        } else {
            $result = Offer::where('store_id', $store->id)->paginate(10);
            return successResponse(data: OfferCollection::collection($result), pagination: $result);
        }
    }

    public function store(OfferRequest $request)
    {
        $user = auth('user')->user();
        $data = $request->validated();
        if (!$store = Store::firstWhere('user_id', $user->id)) {
            return failResponse(__('messages.store_not_found'));
        }
        $data['end_date'] = Carbon::parse($request->start_date)->addDays($request->days_period7);
        $data['image'] = ImageService::save($request, 'offers', 'image');
        $data['store_id'] = $store->id;
        if ($request->terms) {
            $data['terms'] = json_decode($request->terms, true);
        }
        Offer::create($data);
        return successResponse();
    }

    public function update(OfferRequest $request, $id)
    {
        $user = auth('user')->user();
        if (!$store = Store::firstWhere('user_id', $user->id)) {
            return failResponse(__('messages.store_not_found'));
        }
        $offer = Offer::where('id', $id)->where('store_id', $store->id)->first();
        if (!$offer) {
            return failResponse(__('messages.offer_not_found'));
        }
        $data = $request->validated();
        $data['end_date'] = Carbon::parse($request->start_date)->addDays($request->days_period7);
        if ($request->hasFile('image')) {
            $data['image'] = ImageService::save($request, 'offers', 'image');
        }
        if ($request->terms) {
            $data['terms'] = json_decode($request->terms, true);
        }
        $offer->update($data);
        return successResponse();
    }

    public function delete($id)
    {
        $user = auth('user')->user();
        if (!$store = Store::firstWhere('user_id', $user->id)) {
            return failResponse(__('messages.store_not_found'));
        }
        $offer = Offer::where('id', $id)->where('store_id', $store->id)->first();
        if (!$offer) {
            return failResponse(__('messages.offer_not_found'));
        }
        $offer->delete();
        return successResponse();
    }
}
