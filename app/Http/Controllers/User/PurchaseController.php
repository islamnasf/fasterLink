<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceCollection;
use App\Http\Resources\ProductSalesCollection;
use App\Http\Resources\StoreCollection;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function stores()
    {
        $user = auth('user')->user();
        $uniqueInvoices = Invoice::
        where('user_id', $user->id)
        ->distinct()
        ->pluck('store_id')->toArray();
        $uniqueProducts = Product::
        where('user_id', $user->id)
        ->distinct()
        ->pluck('store_id')->toArray();
        $uniqueStores = array_unique(array_merge($uniqueInvoices, $uniqueProducts));
        $stores = Store::whereIn('id', $uniqueStores)->get();

        return successResponse(data: StoreCollection::collection($stores));
    }

    public function invoices(Request $request)
    {
        $user = auth('user')->user();
        $invoices = Invoice::where('user_id', $user->id)->where('store_id', $request->store_id)->get();
        return successResponse(data: InvoiceCollection::collection($invoices));
    }

    public function products(Request $request)
    {
        $user = auth('user')->user();
        $products = Product::where('user_id', $user->id)->where('store_id', $request->store_id)->get();
        return successResponse(data: ProductSalesCollection::collection($products));
    }

}
