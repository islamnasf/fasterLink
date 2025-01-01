<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Element;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
{
    $packages = Package::all();
    $elements = Element::all();  // جلب كل العناصر
    $activeCurrencies = Currency::where('is_active', true)->get();
    return view('panel.packages', compact('packages', 'activeCurrencies','elements'));
}


public function update(Request $request, $id) 
{
    $request->validate([
        'basic_price' => 'required|array', // يجب أن تكون مصفوفة للعديد من العملات
        'multi_branches_price' => 'required|array', // نفس الشيء لأسعار الفروع المتعددة
    ]);

    $package = Package::findOrFail($id);

    // الحصول على العملات النشطة
    $activeCurrencies = Currency::where('is_active', true)->get();

    // تحديث أو إضافة الأسعار بناءً على العملات النشطة فقط
    foreach ($activeCurrencies as $currency) {
        if (isset($request->basic_price[$currency->id])) {
            // التحقق إذا كانت العملة موجودة في packageCurrencies
            $packageCurrency = $package->packageCurrencies()->where('currency_id', $currency->id)->first();

            if ($packageCurrency) {
                // إذا كانت العملة موجودة، نقوم بتحديث قيمتها
                $packageCurrency->update([
                    'basic_price' => $request->basic_price[$currency->id],
                    'multi_branches_price' => $request->multi_branches_price[$currency->id]
                ]);
            } else {
                // إذا لم تكن موجودة، نضيفها
                $package->packageCurrencies()->create([
                    'currency_id' => $currency->id,
                    'basic_price' => $request->basic_price[$currency->id],
                    'multi_branches_price' => $request->multi_branches_price[$currency->id]
                ]);
            }
        }
    }

    return redirect()->back()->with('message', 'Package updated successfully!');
}

public function linkElements(Request $request, Package $package)
{
    $package->elements()->sync($request->elements);

    return redirect()->route('admin.packages.index')->with('message', 'Elements updated successfully');
}  
    
}
