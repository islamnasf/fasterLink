<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ExchangeCasherRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\StoreRequestCollection;
use App\Http\Resources\StoreUserCollection;
use App\Http\Resources\StoreUserRequestCollection;
use App\Http\Services\NotificationService;
use App\Http\Shared\NotificationType;
use App\Http\Shared\PointsSource;
use App\Http\Shared\TransactionType;
use App\Http\Shared\UserRole;
use App\Models\CasherWalletLog;
use App\Models\Notification;
use App\Models\StoreRequest;
use App\Models\User;
use App\Models\UserStore;
use App\Models\Wallet;
use Illuminate\Http\Request;

class StoreUserController extends Controller
{
    //Store
    public function users(Request $request, $id)
    {
        $user = auth('user')->user();
        $userStore = $user->userStores->where('store_id', $id)->first();
        if ($userStore) {
            $users = UserStore::where('store_id', $userStore->store_id)->get();
            $users_pinding = StoreRequest::where('store_id', $userStore->store_id)->get();
            return successResponse(data: StoreUserCollection::collection($users)->merge(StoreUserRequestCollection::collection($users_pinding)));
        }
        return failResponse(__('messages.store_not_found'));
    }

    public function addUser(StoreUserRequest $request, $id)
    {
        $admin = auth('user')->user();
        $adminStore = $admin->userStores->firstWhere('store_id', $id);
        if ($adminStore) {
            if ($adminStore->role == UserRole::casher) {
                return failResponse(__('messages.no_permission'));
            }
            $user = User::firstWhere('phone', $request->phone);
            if ($user) {
                $userStore = UserStore::where('user_id', $user->id)->where('store_id', $id)->first();
                if ($userStore) {
                    return failResponse(__('messages.user_exists'));
                }
                $storeRequest = StoreRequest::where('user_id', $user->id)->where('store_id', $id)->first();
                if ($storeRequest) {
                    return failResponse(__('messages.user_pending'));
                }
                $data = [
                    'store_id' => $id,
                    'user_id' => $user->id,
                    'role' => $request->role
                ];
                if ($request->role == UserRole::casher) {
                    $data['branch_id'] = $request->branch_id;
                }
                $storeRequest = StoreRequest::create($data);
                $notificationService = new NotificationService();
                $notificationService->create(NotificationType::join, $storeRequest, [$user]);
                return successResponse();
            }
            return failResponse(__('messages.user_not_found'));
        }
        return failResponse(__('messages.store_not_found'));
    }

    public function deleteUser(Request $request, $id, $user_id)
    {
        $admin = auth('user')->user();
        $adminStore = $admin->userStores->firstWhere('store_id', $id);
        if ($adminStore) {
            if ($adminStore->role == UserRole::casher) {
                return failResponse(__('messages.no_permission'));
            }
            $userStore = UserStore::where('store_id', $id)->where('user_id', $user_id)->first();
            if ($userStore) {
                $users_count = UserStore::where('store_id', $id)->count();
                if ($users_count>1) {
                    $userStore->delete();
                    return successResponse();
                }
                return failResponse(__('messages.cannot_delete_user'));
            }
            return failResponse(__('messages.user_not_found'));
        }
        return failResponse(__('messages.store_not_found'));
    }

    public function exchange(ExchangeCasherRequest $request, $id, $user_id)
    {
        $admin = auth('user')->user();
        $userStore = UserStore::where('store_id', $id)->where('user_id', $user_id)->first();
        if ($userStore) {

            $casher_wallet = Wallet::where('store_id', $userStore->store_id)->where('user_id', $user_id)->first();
            $previous_casher_points = ($casher_wallet->casher_points ?? 0);
            $previous_casher_rewards = ($casher_wallet->casher_rewards ?? 0);

            if (!$casher_wallet) {
                return failResponse(__('messages.not_have_wallet'));
            }
            if ($request->points) {
                if ($request->points > $casher_wallet->casher_points) {
                    return failResponse(__('messages.points_not_enough'));
                }
                //casher
                $casher_wallet->casher_points = $previous_casher_points - $request->points;
                $casher_wallet->casher_expended_points = ($casher_wallet->casher_expended_points ?? 0) + $request->points;
                $casher_wallet->save();
                //Create log
                CasherWalletLog::create([
                    'points' => $request->points,
                    'previous_points' => $previous_casher_points,
                    'type' => TransactionType::expended,
                    'points_source' => PointsSource::exchangeCasherPoints,
                    'store_id' => $userStore->store_id,
                    'user_id' => $user_id,
                ]);
                //admin
                $admin_wallet = Wallet::where('store_id', $userStore->store_id)->where('user_id', $admin->id)->first() ?? new Wallet();
                $previous_admin_points = ($admin_wallet->casher_points ?? 0);

                $admin_wallet->store_id = $userStore->store_id;
                $admin_wallet->user_id = $admin->id;
                $admin_wallet->expiry_date = date('Y-m-d', strtotime('+1 year'));
                $admin_wallet->casher_points = $previous_admin_points + $request->points;
                $admin_wallet->save();
                //Create log
                CasherWalletLog::create([
                    'points' => $request->points,
                    'previous_points' => $previous_admin_points,
                    'type' => TransactionType::earned,
                    'points_source' => PointsSource::exchangeCasherPoints,
                    'store_id' => $userStore->store_id,
                    'user_id' => $admin->id,
                ]);
                return successResponse();
            } else if ($request->rewards) {

                if ($request->rewards > $casher_wallet->casher_rewards) {
                    return failResponse(__('messages.points_not_enough'));
                }
                //casher
                $casher_wallet->casher_rewards = $previous_casher_rewards - $request->rewards;
                $casher_wallet->casher_expended_rewards = ($casher_wallet->casher_expended_rewards ?? 0) + $request->rewards;
                $casher_wallet->save();
                //Create log
                CasherWalletLog::create([
                    'points' => $request->rewards,
                    'previous_points' => $previous_casher_rewards,
                    'type' => TransactionType::expended_rewards,
                    'points_source' => PointsSource::exchangeCasherRewards,
                    'store_id' => $userStore->store_id,
                    'user_id' => $user_id,
                ]);
                //admin
                $admin_wallet = Wallet::where('store_id', $userStore->store_id)->where('user_id', $admin->id)->first() ?? new Wallet();
                $previous_admin_rewards = ($admin_wallet->casher_rewards ?? 0);
                $admin_wallet->store_id = $userStore->store_id;
                $admin_wallet->user_id = $admin->id;
                $admin_wallet->expiry_date = date('Y-m-d', strtotime('+1 year'));
                $admin_wallet->casher_rewards = $previous_admin_rewards + $request->rewards;
                $admin_wallet->save();
                //Create log
                CasherWalletLog::create([
                    'points' => $request->rewards,
                    'previous_points' => $previous_admin_rewards,
                    'type' => TransactionType::earned_rewards,
                    'points_source' => PointsSource::exchangeCasherRewards,
                    'store_id' => $userStore->store_id,
                    'user_id' => $admin->id,
                ]);
                return successResponse();
            } else {
                return failResponse('You must select the exchange of points or rewards');
            }
        }
        return failResponse(__('messages.user_not_found'));
    }

    //User

    public function requests()
    {
        $user = auth('user')->user();
        $requests = StoreRequest::where('user_id', $user->id)->get();
        return successResponse(data: StoreRequestCollection::collection($requests));
    }

    public function accept(Request $request, $id)
    {
        $user = auth('user')->user();
        $storeRequest = StoreRequest::find($id);
        if ($storeRequest && $storeRequest->user_id == $user->id) {
            if ($request->accept) {
                UserStore::create($storeRequest->toArray());
            }
            Notification::where('user_id', $user->id)->where('relatable_id', $storeRequest->id)->where('relatable_type', get_class($storeRequest))->delete();
            $storeRequest->delete();
            return successResponse();
        }
        return failResponse('Join request not found');
    }
}
