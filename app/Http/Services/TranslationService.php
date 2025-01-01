<?php

namespace App\Http\Services;

use App\Http\Shared\NotificationType;
use Illuminate\Support\Facades\Lang;

class TranslationService
{
    public static function translateTitle($notification, $language = null)
    {
        $title = $notification->title;
        if (Lang::has("messages.$title")) {
            if ($language) {
                $title = __("messages.$title", [], $language);
            } else {
                $title = __("messages.$title");
            }
        }
        return $title;
    }

    public static function translateBody($notification, $language = null)
    {
        $type = $notification->type;
        $body = $notification->body;
        switch ($type) {
            case NotificationType::join:
                $storeRequest = $notification->relatable;
                if ($storeRequest) {
                    $store_name = $storeRequest->store->brand_name ?? "";
                    $role = $storeRequest->role ?? null;
                    $role_name = (Lang::has("messages.$role")) ? __("messages.$role") : "";
                    $message = __("messages.$body");
                    return str_replace(['{store}', '{role}'], [$store_name, $role_name], $message);
                }
                break;
            case NotificationType::reward:
                $reward = $notification->relatable;
                if ($reward) {
                    $reward_name = $reward->reward_name;
                    $store_name = $reward->store->brand_name ?? "";
                    $message = __("messages.$body");
                    return str_replace(['{store}'], [$store_name], $message);
                }
                break;
            case NotificationType::loyaltyComplete:
                $loyaltyLog = $notification->relatable;
                if ($loyaltyLog) {
                    $store_name = $loyaltyLog->store->brand_name ?? "";
                    $message = __("messages.$body");
                    return str_replace(['{store}'], [$store_name], $message);
                }
                break;
            case NotificationType::loyaltyCloseTo:
                $loyaltyLog = $notification->relatable;
                if ($loyaltyLog) {
                    $store_name = $loyaltyLog->store->brand_name ?? "";
                    $message = __("messages.$body");
                    return str_replace(['{store}'], [$store_name], $message);
                }
                break;
            case NotificationType::addPoints:
                $invoice = $notification->relatable;
                if ($invoice) {
                    $points = $invoice->points;
                    $store_name = $invoice->store->brand_name ?? "";
                    $message = __("messages.$body");
                    return str_replace(['{points}','{store}'], [$points,$store_name], $message);
                }
                break;
            case NotificationType::acceptInvoicePoints:
                $invoice = $notification->relatable;
                if ($invoice) {
                    $points = $invoice->points;
                    $store_name = $invoice->store->brand_name ?? "";
                    $message = __("messages.$body");
                    return str_replace(['{points}','{store}'], [$points,$store_name], $message);
                }
                break;
            case NotificationType::acceptInvoiceLoyalty:
                $invoice = $notification->relatable;
                if ($invoice) {
                    $points = $invoice->points;
                    $store_name = $invoice->store->brand_name ?? "";
                    $message = __("messages.$body");
                    return str_replace(['{points}','{store}'], [$points,$store_name], $message);
                }
                break;
            case NotificationType::pointsDeduction:
                $walletLog = $notification->relatable;
                if ($walletLog) {
                    $points = $walletLog->points;
                    $store_name = $walletLog->store->brand_name ?? "";
                    $message = __("messages.$body");
                    return str_replace(['{points}','{store}'], [$points,$store_name], $message);
                }
                break;
            case NotificationType::pointsExchanged:
                $walletLog = $notification->relatable;
                if ($walletLog) {
                    $points = $walletLog->points;
                    $store_name = $walletLog->store->brand_name ?? "";
                    $message = __("messages.$body");
                    return str_replace(['{points}','{store}'], [$points,$store_name], $message);
                }
                break;
            case NotificationType::pointsSharing:
                $walletLog = $notification->relatable;
                if ($walletLog) {
                    $points = $walletLog->points;
                    $store_name = $walletLog->store->brand_name ?? "";
                    $message = __("messages.$body");
                    return str_replace(['{points}','{store}'], [$points,$store_name], $message);
                }
                break;
            case NotificationType::expired:
                $wallet = $notification->relatable;
                if ($wallet) {
                    $expiry_date = $wallet->expiry_date;
                    $message = __("messages.$body");
                    return str_replace(['{date}'], [$expiry_date], $message);
                }
                break;
        }
        if (Lang::has("messages.$body")) {
            if ($language) {
                $body = __("messages.$body", [], $language);
            } else {
                $body = __("messages.$body");
            }
        }
        return $body;
    }


    public static function translateDay($language, $day) {
        $daysTranslation = [
            'en' => [
                'sunday' => 'Sunday',
                'monday' => 'Monday',
                'tuesday' => 'Tuesday',
                'wednesday' => 'Wednesday',
                'thursday' => 'Thursday',
                'friday' => 'Friday',
                'saturday' => 'Saturday'
            ],
            'ar' => [
                'sunday' => 'الأحد',
                'monday' => 'الإثنين',
                'tuesday' => 'الثلاثاء',
                'wednesday' => 'الأربعاء',
                'thursday' => 'الخميس',
                'friday' => 'الجمعة',
                'saturday' => 'السبت'
            ]
        ];
    
        if (isset($daysTranslation[$language][$day])) {
            return $daysTranslation[$language][$day];
        }
    
        return $day;
    }
}
