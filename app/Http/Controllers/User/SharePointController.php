<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ExchangeSharePointRequest;
use App\Http\Requests\User\SharePointRequest;
use App\Http\Resources\SharePointCollection;
use App\Http\Services\NotificationService;
use App\Http\Shared\NotificationType;
use App\Http\Shared\PointsSource;
use App\Http\Shared\TransactionType;
use App\Models\SharePoint;
use App\Models\Store;
use Illuminate\Support\Str;
use App\Models\Wallet;
use App\Models\WalletLog;

class SharePointController extends Controller
{
    //Store
    public function index()
    {
        $user = auth('user')->user();
        $sharePoints = SharePoint::where('user_id', $user->id)->get();
        return successResponse(data: SharePointCollection::collection($sharePoints));
    }

    public function store(SharePointRequest $request)
    {
        $store = Store::find($request->store_id);
        if ($store) {
            $user = auth('user')->user();
            $wallet = Wallet::where('user_id', $user->id)->where('store_id', $store->id)->first();
            if (!$wallet) {
                return failResponse(__('messages.not_have_wallet'));
            }
            if ($request->points > $wallet->points) {
                return failResponse(__('messages.points_not_enough'));
            }
            $code = Str::random(13); // Generate a random string of length 10
            $sharePoint = SharePoint::create([
                'points' => $request->points,
                'code' => $code,
                'store_id' => $store->id,
                'user_id' => $user->id,
            ]);
            //user
            $previous_points = ($wallet->points ?? 0);
            $wallet->points = $previous_points - $request->points;
            $wallet->expended_points = ($wallet->expended_points ?? 0) + $request->points;
            $wallet->save();
            $walletLog = WalletLog::create([
                'points' => $request->points,
                'previous_points' => $previous_points,
                'type' => TransactionType::expended,
                'points_source' => PointsSource::sharePoints,
                'store_id' => $store->id,
                'user_id' => $user->id,
            ]);
            //Push notification
            $notificationService = new NotificationService();
            $notificationService->create(NotificationType::pointsSharing, $walletLog, [$user]);
            return successResponse(data:SharePointCollection::make($sharePoint));
        } else {
            return failResponse(__('messages.store_not_found'));
        }
    }

    public function exchange(ExchangeSharePointRequest $request)
    {
        $sharePoint = SharePoint::firstWhere('code', $request->code);
        if ($sharePoint) {
            $user = auth('user')->user();
            //Update or create wallet
            $wallet = Wallet::where('user_id', $user->id)->where('store_id', $sharePoint->store_id)->first() ?? new Wallet();
            $previous_points = ($wallet->points ?? 0);
            $wallet->store_id = $sharePoint->store_id;
            $wallet->user_id = $user->id;
            $wallet->expiry_date = date('Y-m-d', strtotime('+1 year'));
            $wallet->points = $previous_points + $sharePoint->points;
            $wallet->save();
            //Create log
            WalletLog::create([
                'points' => $sharePoint->points,
                'previous_points' => $previous_points,
                'type' => TransactionType::earned,
                'points_source' => PointsSource::sharePoints,
                'store_id' => $sharePoint->store_id,
                'user_id' => $user->id,
            ]);
            $sharePoint->delete();
            return successResponse();
        }
        return failResponse(__('messages.code_not_found'));
    }
}
