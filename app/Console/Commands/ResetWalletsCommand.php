<?php

namespace App\Console\Commands;

use App\Http\Services\NotificationService;
use App\Http\Shared\NotificationType;
use App\Http\Shared\PointsSource;
use App\Http\Shared\TransactionType;
use App\Models\Loyalty;
use App\Models\Store;
use App\Models\Wallet;
use App\Models\WalletLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ResetWalletsCommand extends Command
{
    protected $signature = 'reset:wallets';

    protected $description = 'Reset wallets if points expire';

    public function handle()
    {
        // Reset points wallets
        $expiryThreshold = Carbon::now()->addDays(30);
        $today = date('Y-m-d');
        
        $wallets = Wallet::on('mysql')->get();
        $wallets_sa = Wallet::on('mysql_sa')->get();

        foreach ($wallets as $wallet) {
            //Push notification if close to expire
            if (Carbon::parse($wallet->expiry_date)->isSameDay($expiryThreshold)) {
                $notificationService = new NotificationService();
                $notificationService->create(NotificationType::expired, $wallet, [$wallet->user]);
            }

            //Reset wallet if expired
            if ($today > $wallet->expiry_date) {
                //Update or create wallet
                $previous_points = ($wallet->points ?? 0);
                $wallet->points = 0;
                $wallet->save();
                //Create log
                WalletLog::on('mysql')->create([
                    'points' => $previous_points,
                    'previous_points' => $previous_points,
                    'type' => TransactionType::expended,
                    'points_source' => PointsSource::expired,
                    'store_id' => $wallet->store_id,
                    'user_id' => $wallet->user_id,
                ]);
            }
        }
        foreach ($wallets_sa as $wallet_sa) {
            //Push notification if close to expire
            if (Carbon::parse($wallet_sa->expiry_date)->isSameDay($expiryThreshold)) {
                $notificationService = new NotificationService();
                $notificationService->create(NotificationType::expired, $wallet_sa, [$wallet_sa->user]);
            }

            //Reset wallet if expired
            if ($today > $wallet_sa->expiry_date) {
                //Update or create wallet
                $previous_points = ($wallet_sa->points ?? 0);
                $wallet_sa->points = 0;
                $wallet_sa->save();
                //Create log
                WalletLog::on('mysql_sa')->create([
                    'points' => $previous_points,
                    'previous_points' => $previous_points,
                    'type' => TransactionType::expended,
                    'points_source' => PointsSource::expired,
                    'store_id' => $wallet_sa->store_id,
                    'user_id' => $wallet_sa->user_id,
                ]);
            }
        }

        // Reset points loyalty
        $stores = Store::on('mysql')->get();
        $stores_sa = Store::on('mysql_sa')->get();

        foreach ($stores as $store) {
            if ($store->loyalty_enabled) {
                if ($today > $store->loyalty_expired) {
                    $store->loyalty_enabled = 0;
                    $store->save();
                    Loyalty::on('mysql')->where('store_id', $store->id)->update(['points' => 0]);
                }
            }
        }
        foreach ($stores_sa as $store_sa) {
            if ($store_sa->loyalty_enabled) {
                if ($today > $store_sa->loyalty_expired) {
                    $store_sa->loyalty_enabled = 0;
                    $store_sa->save();
                    Loyalty::on('mysql_sa')->where('store_id', $store_sa->id)->update(['points' => 0]);
                }
            }
        }

        return Command::SUCCESS;
    }
}
