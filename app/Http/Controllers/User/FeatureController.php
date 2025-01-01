<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AdBarRequest;
use App\Http\Requests\User\BackgroundImageRequest;
use App\Http\Requests\User\EffectButtonRequest;
use App\Http\Requests\User\IntroductionScreenRequest;
use App\Http\Requests\User\StoreSettingRequest;
use App\Http\Resources\StoreFeatureCollection;
use App\Http\Resources\StoreSettingCollection;
use App\Http\Shared\ImageService;
use App\Models\Store;
use Illuminate\Http\Request;

class FeatureController extends Controller
{

    public function index(Request $request)
    {
        $user = auth('user')->user();
        $store = Store::firstWhere('user_id', $user->id);
        if (!$store) {
            return failResponse(__('messages.store_not_found'));
        }
        return successResponse(data: StoreFeatureCollection::make($store));
    }

    public function updateEffectButton(EffectButtonRequest $request)
    {
        $user = auth('user')->user();
        $store = Store::where('user_id', $user->id)->first();
        if (!$store) {
            return failResponse(__('messages.store_not_found'));
        }

        $data = $request->validated();
        $effectButton = $store->effect_button ?? []; // Use an empty array if null
        $updatedEffectButton = array_merge($effectButton, $data);
        $store->effect_button = $updatedEffectButton;
        $store->save();
        return successResponse();
    }

    public function updateIntroductionScreen(IntroductionScreenRequest $request)
    {
        $user = auth('user')->user();
        $store = Store::where('user_id', $user->id)->first();
        if (!$store) {
            return failResponse(__('messages.store_not_found'));
        }

        $data = $request->validated();
        $introductionScreen = $store->introduction_screen ?? [];
        if ($request->hasFile('image')) {
            unset($data['image']);
            $introductionScreen['image'] = ImageService::url(ImageService::save($request, 'introductions', 'image'));
        }
        $updatedIntroductionScreen = array_merge($introductionScreen, $data);
        $store->introduction_screen = $updatedIntroductionScreen;
        $store->save();
        return successResponse();
    }

    public function updateBackgroundImage(BackgroundImageRequest $request)
    {
        $user = auth('user')->user();
        $store = Store::where('user_id', $user->id)->first();
        if (!$store) {
            return failResponse(__('messages.store_not_found'));
        }

        $data = $request->validated();
        $backgroundImage = $store->background_image ?? [];
        if ($request->hasFile('image')) {
            unset($data['image']);
            $backgroundImage['image'] = ImageService::url(ImageService::save($request, 'backgrounds', 'image'));
        }
        $updatedBackgroundImage = array_merge($backgroundImage, $data);
        $store->background_image = $updatedBackgroundImage;
        $store->save();
        return successResponse();
    }

    public function updateAdBar(AdBarRequest $request)
    {
        $user = auth('user')->user();
        $store = Store::where('user_id', $user->id)->first();
        if (!$store) {
            return failResponse(__('messages.store_not_found'));
        }

        $data = $request->validated();
        $adBar = $store->ad_bar ?? []; // Use an empty array if null
        $updatedAdBar = array_merge($adBar, $data);
        $store->ad_bar = $updatedAdBar;
        $store->save();
        return successResponse();
    }
}
