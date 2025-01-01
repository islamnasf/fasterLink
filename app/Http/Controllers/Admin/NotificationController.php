<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\NotificationRequest;
use App\Http\Services\NotificationService;
use App\Http\Shared\ImageService;
use App\Models\JoinRequest;

class NotificationController extends Controller
{

    public function index()
    {
        $topics = ['all'=>'All','user'=>'Users','store'=>'Stores',];
        return view('panel.notifications', compact('topics'));
    }

    public function push(NotificationRequest $request)
    {
        $image=null;
        if ($request->image) {
            $image =ImageService::url(ImageService::save($request, 'notifications'));
        }
        $notificationService = new NotificationService();
        $notificationService->toTopic($request->topic,$request->title,$request->body,$image);
        return back()->with('message', 'Done Successfully');
    }

}
