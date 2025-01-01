<?php

namespace App\Http\Services;

use App\Http\Shared\AppType;
use App\Http\Shared\CountryType;
use App\Http\Shared\NotificationTopic;
use App\Http\Shared\NotificationType;
use App\Models\Notification;
use App\Models\User;

class NotificationService
{

    public function create($notificationType, $relatable, $users)
    {
        $title = '';
        $body = '';
        $app = '';
        switch ($notificationType) {
            case NotificationType::createStore:
                $title = 'create_store_title';
                $body = 'create_store_body';
                $app = AppType::store;
                break;
            case NotificationType::userInvoice:
                $title = 'user_invoice_title';
                $body = 'user_invoice_body';
                $app = AppType::store;
                break;
            case NotificationType::acceptInvoicePoints:
                $title = 'accept_invoice_points_title';
                $body = 'accept_invoice_points_body';
                $app = AppType::store;
                break;
            case NotificationType::acceptInvoiceLoyalty:
                $title = 'accept_invoice_loyalty_title';
                $body = 'accept_invoice_loyalty_body';
                $app = AppType::store;
                break;
            case NotificationType::enableStore:
                $title = 'enable_store_title';
                $body = 'enable_store_body';
                $app = AppType::store;
                break;
            case NotificationType::disableStore:
                $title = 'disable_store_title';
                $body = 'disable_store_body';
                $app = AppType::store;
                break;
            case NotificationType::join:
                $title = 'join_request_title';
                $body = 'join_request_body';
                $app = AppType::user;
                break;
            case NotificationType::reward:
                $title = 'reward_title';
                $body = 'reward_body';
                $app = AppType::user;
                break;
            case NotificationType::addPoints:
                $title = 'add_points_title';
                $body = 'add_points_body';
                $app = AppType::user;
                break;
            case NotificationType::pointsDeduction:
                $title = 'points_deduction_title';
                $body = 'points_deduction_body';
                $app = AppType::user;
                break;
            case NotificationType::pointsExchanged:
                $title = 'points_exchanged_title';
                $body = 'points_exchanged_body';
                $app = AppType::user;
                break;
            case NotificationType::pointsSharing:
                $title = 'points_sharing_title';
                $body = 'points_sharing_body';
                $app = AppType::user;
                break;
            case NotificationType::loyaltyComplete:
                $title = 'loyalty_complete_title';
                $body = 'loyalty_complete_body';
                $app = AppType::user;
                break;
            case NotificationType::loyaltyCloseTo:
                $title = 'loyalty_close_to_title';
                $body = 'loyalty_close_to_body';
                $app = AppType::user;
                break;
            case NotificationType::expired:
                $title = 'expired_title';
                $body = 'expired_body';
                $app = AppType::user;
                break;
        }

        foreach ($users as $user) {
            $notification = new Notification();
            $notification->title = $title;
            $notification->body = $body;
            $notification->user_id = $user->id;
            $notification->type = $notificationType;
            $notification->app = $app;
            $notification->relatable()->associate($relatable);
            $notification->save();
            $title = TranslationService::translateTitle($notification, $user->language);
            $body = TranslationService::translateBody($notification, $user->language);
            if ($app == AppType::store) {
                FirebaseService::pushNotification($title, $body, $user->store_firebase_token);
            } else {
                FirebaseService::pushNotification($title, $body, $user->firebase_token);
            }
        }
    }

    public function toToken($user, $app, $title, $body,$image=null)
    {
        $notification = new Notification();
        $notification->title = $title;
        $notification->body = $body;
        $notification->user_id = $user->id;
        $notification->type = NotificationType::general;
        $notification->app = $app;
        $notification->save();
        
        if ($app == AppType::store) {
            FirebaseService::pushNotification($title, $body, $user->store_firebase_token,$image);
        } else {
            FirebaseService::pushNotification($title, $body, $user->firebase_token,$image);
        }
    }

    public function toTopic($topic, $title, $body,$image=null)
    {
        $users = User::all();
        $data = ['title' => $title, 'body' => $body, 'type' => NotificationType::general];
        if ($topic == 'all') {
            foreach ($users as $user) {
                $data['user_id'] = $user->id;
                $data['app'] = AppType::user;
                Notification::on('mysql')->create($data);
                Notification::on('mysql_sa')->create($data);
            }
            foreach ($users as $user) {
                $data['user_id'] = $user->id;
                $data['app'] = AppType::store;
                Notification::on('mysql')->create($data);
                Notification::on('mysql_sa')->create($data);
            }
        } else {
            if ($topic == NotificationTopic::user) {
                foreach ($users as $user) {
                    $data['user_id'] = $user->id;
                    $data['app'] = NotificationTopic::user;
                    if ($user->country_id == CountryType::saudiArabia) {
                        Notification::on('mysql_sa')->create($data);
                    }else {
                        Notification::on('mysql')->create($data);
                    }
                }
            }else{
                foreach ($users as $user) {
                    $data['user_id'] = $user->id;
                    $data['app'] = $topic;
                    Notification::on('mysql')->create($data);
                    Notification::on('mysql_sa')->create($data);
                }
            }
          
        }

        if ($topic == 'all') {
            FirebaseService::pushNotificationTopic($title, $body, NotificationTopic::user,$image);
            FirebaseService::pushNotificationTopic($title, $body, NotificationTopic::store,$image);
        } else {
            FirebaseService::pushNotificationTopic($title, $body, $topic,$image);
        }
    }
}
