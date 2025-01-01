<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\NotificationRequest;
use App\Http\Services\NotificationService;
use App\Http\Shared\ImageService;
use App\Http\Shared\PointsType;
use App\Models\Country;
use App\Models\Invoice;
use App\Models\Loyalty;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // $country_id = session('desired_connection')=='mysql'?1:2;
        $users = User::all();
        $countries = Country::all();
        return view('panel.users', compact('users', 'countries'));
    }

    public function usersCountry(Request $request)
    {
        $countries = Country::all();
        $country_id = $request->get('country_id'); 
    
        if (is_null($country_id) || $country_id === '') {
            $users = User::all();
        } else {
            $users = User::where('country_id', $country_id)->get(); 
        }
        return view('panel.users', compact('users', 'countries'));
    }
    


    public function delete($id)
    {
        $user = User::findOrFail($id);
        ImageService::delete($user->image);
        $user->delete();
        return back()->with('message', 'Done Successfully');
    }

    public function cashback($id)
    {
        $user = User::findOrFail($id);
        $invoices = Invoice::where('user_id', $user->id)->where('points_type', PointsType::cashback)->get();
        return view('panel.cashback', compact('invoices'));
    }

    public function loyalty($id)
    {
        $user = User::findOrFail($id);
        $loyalties = Loyalty::where('user_id', $user->id)->get();
        return view('panel.loyalties', compact('loyalties'));
    }
    
    public function notification(Request $request,$id)
    {
        $user = User::findOrFail($id);
        $image=null;
        if ($request->image) {
            $image =ImageService::url(ImageService::save($request, 'notifications'));
        }
        $notificationService = new NotificationService();
        $notificationService->toToken($user,$request->app,$request->title,$request->body,$image);
        return back()->with('message', 'Done Successfully');
    }
    
}
