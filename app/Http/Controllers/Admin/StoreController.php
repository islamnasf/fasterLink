<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\NotificationService;
use App\Http\Shared\ImageService;
use App\Http\Shared\NotificationTopic;
use App\Http\Shared\NotificationType;
use App\Models\Department;
use App\Models\Invoice;
use App\Models\Reward;
use App\Models\Store;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class StoreController extends Controller
{

    public function index(Request $request)
    {
        $stores = Store::query();
        if ($request->status) {
            $stores->where('active', ($request->status == 'active') ? 1 : 0);
        }
        $stores = $stores->withAvg('ratings', 'rating')->orderBy('created_at', 'desc')->get();
        return view('panel.stores', compact('stores'));
    }

    public function update(Request $request, $id)
    {
        $store = Store::findOrFail($id);
    
        $request->validate([
            'brand_name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);
    
        $data = $request->only('brand_name', 'category_id');
        if ($request->hasFile('logo')) {
            ImageService::delete($store->logo);
            $data['logo'] = ImageService::upload($request->file('logo'));
        }
    
        $store->update($data);
    
        return back()->with('message', 'Store updated successfully.');
    }



    public function details($id)
    {
        $store = Store::findOrFail($id);

        $invoices = Invoice::where('store_id', $store->id)->select([
            DB::raw('SUM(total) as totalSum'),
            DB::raw('COUNT(*) as rowCount')
        ])
            ->first();

        $wallets = Wallet::where('store_id', $store->id)->select([
            DB::raw('SUM(points) as pointsSum'),
            DB::raw('COUNT(*) as rowCount')
        ])
            ->first();

        $rewards = Reward::where('store_id', $store->id)->select([
            DB::raw('COUNT(*) as rowCount')
        ])
            ->first();

        return view('panel.store_details', compact('store', 'invoices', 'wallets', 'rewards'));
    }

    public function status(Request $request, $id)
    {
        $store = Store::findOrFail($id);
        $welcome = ($store->created_at == $store->updated_at);

        $active = (isset($request->active) && $request->active == 'on') ? 1 : 0;
        $store->update(['active' => $active]);
        //Push notification
        $notificationService = new NotificationService();
        if ($active) {
            $notificationType = NotificationType::enableStore;
            if ($welcome) {
                $notificationService->toTopic(NotificationTopic::user,'الترحيب بانضمام متجر', "نرحب بانضمام متجر {$store->brand_name} لتطبيق نكسب ، يمكنك الآن التسوق منه وتجميع النقاط");
            }
        } else {
            $notificationType = NotificationType::disableStore;
        }
        $notificationService->create($notificationType, $store, $store->users);
        return back()->with('message', 'Done Successfully');
    }

    public function delete($id)
    {
        $store = Store::findOrFail($id);
        ImageService::delete($store->image);
        $store->delete();
        return back()->with('message', 'Done Successfully');
    }

    public function branches($id)
    {
        $store = Store::findOrFail($id);
        $branches = $store->branches;
        return view('panel.branches', compact('branches'));
    }

    public function departments($id)
    {
        $store = Store::findOrFail($id);
        $departments = $store->departments;
        return view('panel.departments', compact('departments'));
    }
    public function departmentDelete($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
    
        return redirect()->back()->with('success', 'Department deleted successfully.');
    }
}
