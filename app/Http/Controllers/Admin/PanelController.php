<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\ProfileRequest;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\Loyalty;
use App\Models\Package;
use App\Models\Product;
use App\Models\Reward;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PanelController extends Controller
{

    public function index()
    {
        $stores_count = Store::count();
        $categories_count = Category::count();
        $users_count = User::count();
        $branches_count = Branch::count();
        $packages_count = Package::count();


        return view('panel.index',compact('stores_count','categories_count','users_count','branches_count','packages_count'));
    }

    public function profile()
    {
        $admin =Admin::firstWhere('email',auth('admin')->user()->email);
        return view('panel.profile',compact('admin'));
    }

    public function updateProfile(ProfileRequest $request)
    {
        $admin = auth('admin')->user();
        $data = $request->validated();
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }else {
            unset($data['password']);
        }
        try {
             // Start the transaction
             DB::connection('mysql')->beginTransaction();
             DB::connection('mysql_sa')->beginTransaction();
             // Perform database operations within the transaction
             $admin_eg =Admin::on('mysql')->firstWhere('email',$admin->email);
             $admin_sa =Admin::on('mysql_sa')->firstWhere('email',$admin->email);
             $admin_eg->update($data);
             $admin_sa->update($data);
             // Commit the transaction
             DB::connection('mysql')->commit();
             DB::connection('mysql_sa')->commit();
        } catch (\Throwable $th) {
             // An error occurred, rollback the transaction
             DB::connection('mysql')->rollBack();
             DB::connection('mysql_sa')->rollBack();
             // Handle the exception or log the error
             Log::error('Update Admin Profile Transaction failed: ' . $th->getMessage());
             return back()->withErrors('Something went wrong, please try again');
        }
        return back()->with('message', 'Done Successfully');
    }

}
