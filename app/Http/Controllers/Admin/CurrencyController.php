<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::all();
        return view('panel.currencies', compact('currencies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'country' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:currencies',
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
        ]);

        Currency::create([
            'country' => $request->country,
            'code' => $request->code,
            'name' => $request->name,
            'symbol' => $request->symbol,
        ]);

        return redirect()->back()->with('message', 'Currency created successfully');
    }

    public function update(Request $request, $id)
    {
        $currency = Currency::findOrFail($id);

        $request->validate([
            'country' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:currencies,code,' . $currency->id,
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
        ]);

        $currency->update([
            'country' => $request->country,
            'code' => $request->code,
            'name' => $request->name,
            'symbol' => $request->symbol,
        ]);

        return redirect()->back()->with('message', 'Currency updated successfully');
    }

    public function delete($id)
    {
        Currency::findOrFail($id)->delete();
        return redirect()->back()->with('message', 'Currency deleted successfully');
    }

    public function active($id)
    {
        $currency = Currency::findOrFail($id);
        $currency->is_active = !$currency->is_active;
        $currency->save();

        return redirect()->back();
    }
}
