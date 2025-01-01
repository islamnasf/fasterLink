<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Resources\StoreCollection;
use App\Http\Shared\ImageService;
use App\Models\Invoice;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $user = auth('user')->user();
        $store = Store::firstWhere('user_id', $user->id);
        if (!$store) {
            return failResponse(__('messages.store_not_found'));
        }
        return successResponse(data: StoreCollection::make($store));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $user = auth('user')->user();
        $invoice = Invoice::where('user_id', $user->id)->where('type', 'new')->where('payment_status', 1)->first();
        if (!$invoice) {
            return failResponse('You must purchase a package first.');
        }
        $data['package_id'] = $invoice->package_id;
        $data['multi_branches'] = $invoice->multi_branches;
        $data['user_id'] = $user->id;
        $data['logo'] = ImageService::save($request, 'stores', 'logo');
        $data['start_date'] = Carbon::today();
        $data['expiry_date'] = Carbon::today()->addDays(14);
        
        if ($request->cover_type == 'images') {
            $data['cover_images'] = ImageService::saveArray($request, 'stores/covers', 'cover_images');
        }
        Store::create($data);
        return successResponse();
    }

    public function update(StoreRequest $request,$id)
    {
        $user = auth('user')->user();
        $store = Store::where('user_id', $user->id)->first();
        if (!$store) {
            return failResponse(__('messages.store_not_found'));
        }
        $data = $request->validated();
        if ($request->hasFile('logo')) {
            $data['logo'] = ImageService::save($request, 'stores', 'logo');
        }
        if ($request->cover_type == 'images') {
            if ($request->hasFile('cover_images')) {
                $data['cover_images'] = ImageService::saveArray($request, 'stores/covers', 'cover_images');
            }
        }
        $store->update($data);
        return successResponse();
    }

    public function deleteImages(Request $request)
    {
        $store = Store::find($request->store_id);
        if ($store) {
            foreach ($request->cover_images as $cover_image) {
                $images = $store->cover_images;
                $url = $cover_image;
                $path = ImageService::path($url);
                $key = array_search($path, $images);
                if ($key === FALSE) {
                } else {
                    ImageService::delete($path);
                    unset($images[$key]);
                    $store->update(['cover_images' => array_values($images)]);
                }
            }
        }
        return successResponse();
    }
}
