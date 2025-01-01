<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ExchangeRequest;
use App\Http\Requests\User\InvoicePointsRequest;
use App\Http\Requests\User\ScanRequest;
use App\Http\Resources\BranchCollection;
use App\Http\Resources\CasherUserCollection;
use App\Http\Resources\InvoiceCollection;
use App\Http\Resources\RewardCollection;
use App\Http\Resources\UserScanCollection;
use App\Http\Services\NotificationService;
use App\Http\Shared\CodeType;
use App\Http\Shared\LoyaltyType;
use App\Http\Shared\NotificationType;
use App\Http\Shared\PointsSource;
use App\Http\Shared\PointsType;
use App\Http\Shared\TransactionType;
use App\Models\CasherWalletLog;
use App\Models\Invoice;
use App\Models\Loyalty;
use App\Models\LoyaltyLog;
use App\Models\Product;
use App\Models\Reward;
use App\Models\Store;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletLog;
use Illuminate\Support\Facades\Log;

class ScanController extends Controller
{
    public function scan(ScanRequest $request)
    {
        if ($request->code) {
            $codeType = substr($request->code, 0, 3);
            switch ($codeType) {
                case CodeType::product:
                    $product = Product::firstWhere('code', $request->code);
                    if ($product) {
                        $store = $product->store;
                        if (!$store) {
                            // return failResponse(__('messages.store_not_found'));
                            return failResponse(__('messages.code_not_found'));
                        }
                        if ($product->user_id) {
                            return failResponse(__('messages.used_code'));
                        }
                        if ($store->loyalty_enabled) {
                            return successResponse(data: UserScanCollection::make($product));
                        } else {
                            return failResponse(__('messages.offers_disabled'));
                        }
                    }
                    break;
                case CodeType::reward:
                    $reward = Reward::firstWhere('code', $request->code);
                    if ($reward) {
                        if ($reward->is_used) {
                            return failResponse(__('messages.used_code'));
                        }
                        $store = $reward->store;
                        if ($store->loyalty_enabled) {
                            if (date('Y-m-d') > $store->loyalty_expired) {
                                return failResponse(__('messages.loyalty_expired'));
                            }
                            return successResponse(data: RewardCollection::make($reward));
                        } else {
                            return failResponse(__('messages.offers_disabled'));
                        }
                    }
                    break;
                case CodeType::user:
                    $user = User::firstWhere('code', $request->code);
                    if ($user) {
                        //casher user
                        $wallet = Wallet::where('store_id', $request->store_id)->where('user_id', $user->id)->first();
                        if ($wallet) {
                            $user->points = (int) $wallet->points;
                            $user->casher_points = (int) $wallet->casher_points;
                        }
                        $userStore = $user->userStores->where('store_id', $request->store_id)->first();
                        if ($userStore) {
                            $user->role = $userStore->role;
                            $user->branch = BranchCollection::make($userStore->branch);
                        }
                        $rewards = Reward::where('store_id', $request->store_id)->where('user_id', $user->id)->where('is_used', 0)->get();
                        if ($rewards) {
                            $user->rewards = RewardCollection::collection($rewards);
                        }
                        $user->rewards_count = (int) Reward::where('store_id', $request->store_id)->where('casher_id', $user->id)->count() ?? 0;
                        $user->invoices_count = (int) Invoice::where('store_id', $request->store_id)->where('casher_id', $user->id)->count() ?? 0;
                        //if normal user
                        $user->invoices = InvoiceCollection::collection(Invoice::where('store_id', $request->store_id)->where('user_id', $user->id)->get());

                        return successResponse(data: CasherUserCollection::make($user));
                    }
                    break;
            }
            return failResponse(__('messages.code_not_found'));
        }
        //is_electronic_invoice 0
        else if ($request->invoice_number) {
            $invoice = Invoice::withTrashed()->firstWhere('invoice_number', $request->invoice_number);
            if ($invoice) {
                //Get store
                $store = Store::find($invoice->store_id);
                if (!$store) {
                    // return failResponse(__('messages.store_not_found'));
                    return failResponse(__('messages.code_not_found'));
                }
                if ($invoice->user_id) {
                    return failResponse(__('messages.invoice_used'));
                }
                if ($store->loyalty_enabled || $store->cashback_enabled) {
                    return successResponse(data: UserScanCollection::make($invoice));
                } else {
                    return failResponse(__('messages.offers_disabled'));
                }
            }
            return failResponse(__('messages.code_not_found'));
        }
        //is_electronic_invoice 1
        else if ($request->tax_number) {
            $store = Store::firstWhere('tax_number', $request->tax_number);
            if (!$store) {
                return failResponse(__('messages.code_not_found'));
            }
            if (!$store->loyalty_enabled && !$store->cashback_enabled) {
                return failResponse(__('messages.offers_disabled'));
            }
            $invoice = Invoice::withTrashed()->where('store_id', $store->id)->where('invoice_date', $request->invoice_date)->where('total', $request->total)->first();

            if ($invoice && $invoice->user_id) {
                return failResponse(__('messages.invoice_used'));
            }

            if ($store->is_invoice_coding) {
                if ($invoice) {
                    return successResponse(data: UserScanCollection::make($invoice));
                }
                return failResponse(__('messages.code_not_found'));
            } else {
                //loyalty
                if ($store->loyalty_enabled) {
                    if (date('Y-m-d') > $store->loyalty_expired) {
                        return failResponse(__('messages.loyalty_expired'));
                    }
                    if ($store->loyalty_type == LoyaltyType::invoice) {
                        $earned_points =  $request->total;
                        $points_type = PointsType::loyalty;
                    } else {
                        return failResponse(__('messages.offers_disabled'));
                    }
                }
                //cashback
                else {
                    $earned_points = round($request->total * ($store->cashback_percentage / 100));
                    $points_type = PointsType::cashback;
                }
                try {
                    if ($invoice) {
                        return successResponse(data: UserScanCollection::make($invoice));
                    }
                    $invoice = Invoice::create([
                        'store_id' => $store->id,
                        'code' => uniqid("inv_"),
                        'invoice_number' => time(),
                        'invoice_date' => $request->invoice_date,
                        'total' => $request->total,

                        'points_type' => $points_type,
                        'cashback_percentage' => $store->cashback_percentage ?? 0,
                        'points' => $earned_points,
                    ]);
                    return successResponse(data: UserScanCollection::make($invoice));
                } catch (\Throwable $th) {
                    // Handle the exception or log the error
                    Log::error('Scan Invoice failed: ' . $th->getMessage());
                    return back()->withErrors('Something went wrong, please try again');
                }
            }
        }
        return failResponse(__('messages.code_not_found'));
    }

    public function exchange(ExchangeRequest $request)
    {
        $codeType = substr($request->code, 0, 3);
        $user = auth('user')->user();
        switch ($codeType) {
            case CodeType::product:
                $product = Product::firstWhere('code', $request->code);
                if ($product) {
                    if ($product->user_id) {
                        return failResponse(__('messages.used_code'));
                    }
                    $store = $product->store;
                    if (!$store) {
                        // return failResponse(__('messages.store_not_found'));
                        return failResponse(__('messages.code_not_found'));
                    }
                    if ($store->loyalty_enabled) {
                        if (date('Y-m-d') > $store->loyalty_expired) {
                            return failResponse(__('messages.loyalty_expired'));
                        }
                        $earned_points = $store->loyalty_product_points_in_code;

                        //Update or create Loyalty
                        $loyalty = Loyalty::where('user_id', $user->id)->where('store_id', $store->id)->first() ?? new Loyalty();
                        $loyalty->store_id = $store->id;
                        $loyalty->user_id = $user->id;
                        $loyalty->points = ($loyalty->points ?? 0) + $earned_points;
                        $loyalty->save();
                        $loyaltyLog = LoyaltyLog::create([
                            'points' => $earned_points,
                            'type' => PointsSource::product,
                            'store_id' => $store->id,
                            'user_id' => $user->id
                        ]);
                        if (($loyalty->points / $store->loyalty_product_points) >= 0.8) {
                            //Push notification
                            $notificationService = new NotificationService();
                            $notificationService->create(NotificationType::loyaltyCloseTo, $loyaltyLog, [$user]);
                        }
                        if ($loyalty->points >= $store->loyalty_product_points) {
                            //Push notification
                            $notificationService = new NotificationService();
                            $notificationService->create(NotificationType::loyaltyComplete, $loyaltyLog, [$user]);
                            Reward::create([
                                'user_id' => $user->id,
                                'store_id' => $store->id,
                                'code' => uniqid("rwd_"),
                                'reward_type' => $store->reward_type,
                                'reward_name' => $store->reward_name,
                            ]);
                            $loyalty->delete();
                        }
                        //Update product
                        $product->user_id = $user->id;
                        $product->save();
                        return successResponse(); //data: ProductCollection::make($product)
                    } else {
                        return failResponse(__('messages.offers_disabled'));
                    }
                }
                break;
            case CodeType::invoice:
                $invoice = Invoice::firstWhere('code', $request->code);
                if ($invoice) {
                    if ($invoice->user_id) {
                        return failResponse(__('messages.invoice_used'));
                    }
                    $store = $invoice->store;
                    if (!$store) {
                        // return failResponse(__('messages.store_not_found'));
                        return failResponse(__('messages.code_not_found'));
                    }
                    if ($store->loyalty_enabled || $store->cashback_enabled) {
                        //loyalty
                        if ($store->loyalty_enabled) {
                            if (date('Y-m-d') > $store->loyalty_expired) {
                                return failResponse(__('messages.loyalty_expired'));
                            }
                            $earned_points = $invoice->total;
                            $points_type = PointsType::loyalty;
                            //Update or create Loyalty
                            $loyalty = Loyalty::where('user_id', $user->id)->where('store_id', $store->id)->first() ?? new Loyalty();
                            $loyalty->store_id = $store->id;
                            $loyalty->user_id = $user->id;
                            $loyalty->points = ($loyalty->points ?? 0) + $earned_points;
                            $loyalty->save();
                            $loyaltyLog = LoyaltyLog::create([
                                'points' => $earned_points,
                                'type' => PointsSource::invoice,
                                'store_id' => $store->id,
                                'user_id' => $user->id
                            ]);

                            if (($loyalty->points / $store->loyalty_invoice_amount) >= 0.8) {
                                //Push notification
                                $notificationService = new NotificationService();
                                $notificationService->create(NotificationType::loyaltyCloseTo, $loyaltyLog, [$user]);
                            }

                            if ($loyalty->points >= $store->loyalty_invoice_amount) {
                                // $counter = ceil($loyalty->points / $store->loyalty_invoice_amount);
                                // $remain = $loyalty->points;
                                //Push notification
                                $notificationService = new NotificationService();
                                $notificationService->create(NotificationType::loyaltyComplete, $loyaltyLog, [$user]);
                                // for ($i = 0; $i < $counter; $i++) {
                                Reward::create([
                                    'user_id' => $user->id,
                                    'store_id' => $store->id,
                                    'code' => uniqid("rwd_"),
                                    'reward_type' => $store->reward_type,
                                    'reward_name' => $store->reward_name,
                                ]);
                                // $remain -= $store->loyalty_invoice_amount;
                                // if ($remain < $store->loyalty_invoice_amount) {
                                //     break;
                                // }
                                // }
                                $loyalty->update(['points' => 0]); //$remain
                            }
                        }
                        //cashback
                        else {
                            $earned_points = round($invoice->total * ($store->cashback_percentage / 100));
                            $points_type = PointsType::cashback;
                            //Update or create wallet
                            $wallet = Wallet::where('user_id', $user->id)->where('store_id', $store->id)->first() ?? new Wallet();
                            $previous_points = ($wallet->points ?? 0);
                            $wallet->store_id = $store->id;
                            $wallet->user_id = $user->id;
                            $wallet->expiry_date = date('Y-m-d', strtotime('+1 year'));
                            $wallet->points = $previous_points + $earned_points;
                            $wallet->save();
                            //Create log
                            WalletLog::create([
                                'points' => $earned_points,
                                'previous_points' => $previous_points,
                                'type' => TransactionType::earned,
                                'points_source' => PointsSource::invoice,
                                'store_id' => $store->id,
                                'user_id' => $user->id,
                            ]);
                        }
                        //Update invoice
                        $invoice->user_id = $user->id;
                        $invoice->points_type = $points_type;
                        $invoice->points = $earned_points;
                        if ($points_type == PointsType::cashback) {
                            $invoice->cashback_percentage = $store->cashback_percentage;
                        }
                        $invoice->save();
                        return successResponse(__('messages.done_add_points')); //data: InvoiceCollection::make($invoice)
                    } else {
                        return failResponse(__('messages.offers_disabled'));
                    }
                }
                break;
            case CodeType::reward:
                $reward = Reward::firstWhere('code', $request->code);
                if ($reward) {
                    if ($reward->is_used) {
                        return failResponse(__('messages.used_code'));
                    }
                    $store = $reward->store;
                    if ($store->loyalty_enabled) {
                        if (date('Y-m-d') > $store->loyalty_expired) {
                            return failResponse(__('messages.loyalty_expired'));
                        }
                        $casher = auth('user')->user();
                        if ($reward->reward_type == 2) {
                            $earned_points =  $store->reward_points;
                            //Update or create wallet
                            $wallet = Wallet::where('user_id', $reward->user_id)->where('store_id', $store->id)->first() ?? new Wallet();
                            $previous_points = ($wallet->points ?? 0);
                            $wallet->store_id = $store->id;
                            $wallet->user_id = $reward->user_id;
                            $wallet->expiry_date = date('Y-m-d', strtotime('+1 year'));
                            $wallet->points = $previous_points + $earned_points;
                            $wallet->save();
                            //Create log
                            WalletLog::create([
                                'points' => $earned_points,
                                'previous_points' => $previous_points,
                                'type' => TransactionType::earned,
                                'points_source' => PointsSource::reward,
                                'store_id' => $store->id,
                                'user_id' => $reward->user_id
                            ]);
                        }
                        //Update reward
                        $reward->is_used = 1;
                        $reward->casher_id = $casher->id;
                        $reward->save();
                        //Push notification
                        $notificationService = new NotificationService();
                        $notificationService->create(NotificationType::reward, $reward, [$user]);
                        return successResponse(__('messages.done_exchange_rewards')); //data: RewardCollection::make($reward)
                    } else {
                        return failResponse(__('messages.offers_disabled'));
                    }
                }
                break;
            case CodeType::user:
                $user = User::firstWhere('code', $request->code);
                if ($user) {
                    $casher = auth('user')->user();
                    $store = Store::find($request->store_id);
                    $wallet = Wallet::where('user_id', $user->id)->where('store_id', $store->id)->first();
                    $previous_points = ($wallet->points ?? 0);
                    if (!$wallet) {
                        return failResponse(__('messages.not_have_wallet'));
                    }
                    if ($request->points > $wallet->points) {
                        return failResponse(__('messages.points_not_enough'));
                    }
                    //user
                    $wallet->points = $previous_points - $request->points;
                    $wallet->expended_points = ($wallet->expended_points ?? 0) + $request->points;
                    $wallet->save();
                    $walletLog = WalletLog::create([
                        'points' => $request->points,
                        'previous_points' => $previous_points,
                        'type' => TransactionType::expended,
                        'points_source' => PointsSource::exchangeClientPoints,
                        'store_id' => $store->id,
                        'user_id' => $user->id,
                        'casher_id' => $casher->id,
                    ]);
                    //Push notification
                    $notificationService = new NotificationService();
                    $notificationService->create(NotificationType::pointsExchanged, $walletLog, [$user]);
                    //casher
                    $casher_wallet = Wallet::where('user_id', $casher->id)->where('store_id', $store->id)->first() ?? new Wallet();
                    $previous_casher_points = ($casher_wallet->casher_points ?? 0);
                    $casher_wallet->casher_points = $previous_casher_points + $request->points;
                    $casher_wallet->save();
                    CasherWalletLog::create([
                        'points' => $request->points,
                        'previous_points' => $previous_casher_points,
                        'type' => TransactionType::earned,
                        'points_source' => PointsSource::exchangeClientPoints,
                        'store_id' => $store->id,
                        'user_id' => $user->id,
                    ]);
                    return successResponse(__('messages.done_exchange_points'));
                } else {
                    return failResponse(__('messages.code_not_found'));
                }
                break;
        }
        return failResponse(__('messages.code_not_found'));
    }

    public function points(InvoicePointsRequest $request)
    {
        $store = Store::find($request->store_id);
        if (!$store->active) {
            return failResponse(__('messages.store_inactive'));
        }
        $casher = auth('user')->user();
        $user = User::firstWhere('code', $request->code);
        if ($user) {
            if ($store->loyalty_enabled || $store->cashback_enabled) {
                //loyalty
                if ($store->loyalty_enabled) {
                    if (date('Y-m-d') > $store->loyalty_expired) {
                        return failResponse(__('messages.loyalty_expired'));
                    }
                    if ($store->loyalty_type == LoyaltyType::invoice) {
                        $earned_points =  $request->total;
                        $points_type = PointsType::loyalty;
                    } else {
                        return failResponse(__('messages.offers_disabled'));
                    }
                }
                //cashback
                else {
                    $earned_points = round($request->total * ($store->cashback_percentage / 100));
                    $points_type = PointsType::cashback;
                }
                try {
                    $invoice = Invoice::create([
                        'store_id' => $store->id,
                        'user_id' => $user->id,
                        'code' => uniqid("inv_"),
                        'invoice_number' => time(),
                        'invoice_date' => $request->invoice_date,
                        'total' => $request->total,

                        'points_type' => $points_type,
                        'cashback_percentage' => $store->cashback_percentage ?? 0,
                        'points' => $earned_points,
                        'casher_id' => $casher->id
                    ]);

                    //Push notification
                    $notificationService = new NotificationService();
                    $notificationService->create(NotificationType::addPoints, $invoice, [$user]);

                    //loyalty
                    if ($store->loyalty_enabled) {

                        //Update or create Loyalty
                        $loyalty = Loyalty::where('user_id', $user->id)->where('store_id', $store->id)->first() ?? new Loyalty();
                        $loyalty->store_id = $store->id;
                        $loyalty->user_id = $user->id;
                        $loyalty->points = ($loyalty->points ?? 0) + $earned_points;
                        $loyalty->save();
                        $loyaltyLog = LoyaltyLog::create([
                            'points' => $earned_points,
                            'type' => PointsSource::invoice,
                            'store_id' => $store->id,
                            'user_id' => $user->id
                        ]);

                        if ($loyalty->points >= $store->loyalty_invoice_amount) {
                            //Push notification
                            $notificationService = new NotificationService();
                            $notificationService->create(NotificationType::loyaltyComplete, $loyaltyLog, [$user]);
                            Reward::create([
                                'user_id' => $user->id,
                                'store_id' => $store->id,
                                'code' => uniqid("rwd_"),
                                'reward_type' => $store->reward_type,
                                'reward_name' => $store->reward_name,
                            ]);
                            $loyalty->update(['points' => 0]);
                        } elseif (($loyalty->points / $store->loyalty_invoice_amount) >= 0.8) {
                            //Push notification
                            $notificationService = new NotificationService();
                            $notificationService->create(NotificationType::loyaltyCloseTo, $loyaltyLog, [$user]);
                        }
                    }
                    //cashback
                    else {
                        $wallet = Wallet::where('user_id', $user->id)->where('store_id', $store->id)->first() ?? new Wallet();
                        $previous_points = ($wallet->points ?? 0);
                        $wallet->store_id = $store->id;
                        $wallet->user_id = $user->id;
                        $wallet->expiry_date = date('Y-m-d', strtotime('+1 year'));
                        $wallet->points = $previous_points + $earned_points;
                        $wallet->save();
                        WalletLog::create([
                            'points' => $earned_points,
                            'previous_points' => $previous_points,
                            'type' => TransactionType::earned,
                            'points_source' => PointsSource::invoice,
                            'store_id' => $store->id,
                            'user_id' => $user->id
                        ]);
                    }

                    return successResponse(data: InvoiceCollection::make($invoice));
                } catch (\Throwable $th) {
                    // Handle the exception or log the error
                    Log::error('Add Points failed: ' . $th->getMessage());
                    return back()->withErrors('Something went wrong, please try again');
                }
            } else {
                return failResponse(__('messages.offers_disabled'));
            }
        } else {
            return failResponse(__('messages.code_not_found'));
        }
    }
}
