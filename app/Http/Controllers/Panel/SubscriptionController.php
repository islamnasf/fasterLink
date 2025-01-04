<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceCollection;
use App\Http\Resources\SubscriptionCollection;
use App\Models\Invoice;
use App\Models\Package;
use App\Models\Store;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth('user')->user();
        $store = Store::firstWhere('user_id', $user->id);
        if (!$store) {
            return failResponse(__('messages.store_not_found'));
        }
        return successResponse(data: SubscriptionCollection::make($store));
    }

    public function new(Request $request)
    {
        $user = auth('user')->user();
        if (Store::where('user_id', $user->id)->first()) {
            return failResponse('You already have a store');
        }
        
        $package = Package::find($request->package_id);

        $invoice = Invoice::create([
            'user_id' => $user->id,
            'country_id' => $request->country_id,
            'package_id' => $package->id,
            'multi_branches' => $request->multi_branches,
            // 'subtotal' => ($request->multi_branches) ? $package->multi_branches_price : $package->basic_price,
            'subtotal' => $request->subtotal,

            'discount' => '100',
            'grand_total' => '0.00',
            'payment_status' => 1,
            'type' => 'new',
        ]);

        return successResponse(data: InvoiceCollection::make($invoice));
    }
}
