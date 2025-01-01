<?php

namespace App\Console\Commands;

use App\Http\Shared\PointsSource;
use App\Http\Shared\TransactionType;
use App\Models\SharePoint;
use App\Models\Wallet;
use App\Models\WalletLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ReturnPointsCommand extends Command
{
    protected $signature = 'points:return';

    protected $description = 'Return points to users if 10 days have passed';

    public function handle()
    {
        $tenDaysAgo = Carbon::now()->subDays(10);
        
        $expiredSharePoints = SharePoint::where('created_at', '<=', $tenDaysAgo)->get();
        
        foreach ($expiredSharePoints as $sharePoint) {
            //Update or create wallet
            $wallet = Wallet::where('user_id', $sharePoint->user_id)->where('store_id', $sharePoint->store_id)->first() ?? new Wallet();
            $previous_points = ($wallet->points ?? 0); 
            $wallet->store_id = $sharePoint->store_id;
            $wallet->user_id = $sharePoint->user_id;
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
                'user_id' => $sharePoint->user_id,
            ]);
            $sharePoint->delete();
        }
        return Command::SUCCESS;
    }
}
