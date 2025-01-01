<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\NotificationGetRequest;
use App\Http\Requests\User\ReadRequest;
use App\Http\Resources\NotificationCollection;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index(NotificationGetRequest $request)
    {
        $user = auth('user')->user();
        $notifications = Notification::where('user_id', $user->id)->where('app', $request->app)->orderBy('created_at', 'desc');
        $result = $notifications->paginate(10);
        $notificationsCollection = NotificationCollection::collection($result);
        $notifications->update(['is_read' => 1]);
        return successResponse(data: $notificationsCollection, pagination: $result);
    }

    public function count(NotificationGetRequest $request)
    {
        $user = auth('user')->user();
        $count = Notification::where('user_id', $user->id)->where('app', $request->app)->where('is_read', 0)->count();
        return successResponse(data: ['count' => (int)$count]);
    }

    public function read(ReadRequest $request)
    {
        $user = auth('user')->user();
        $notification = Notification::where('id',$request->notification_id)->where('user_id', $user->id)->first();
        if ($notification) {
            $notification->update(['is_read' => 1]);
            return successResponse();
        }
        return failResponse('Notification not found');
    }
}
