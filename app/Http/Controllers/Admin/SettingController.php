<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{

    public function index(Request $request)
    {
        $settings = Setting::all();
        return view('panel.settings', compact('settings'));
    }

    // public function changeCountry(Request $request)
    // {
    //     if ($request->country == "SA") {
    //         session(['desired_connection' => 'mysql_sa']);
    //     } else {
    //         session(['desired_connection' => 'mysql']);
    //     }
    //     return successResponse();
    // }

    public function update(Request $request)
    {
        $data = $this->rederData($request);
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        return back()->with('message', 'Done Successfully');
    }

    public function rederData($request)
    {
        $data = $request->except(['_method', '_token']);
        return $data;
    }

    public function socialLinks()
    {
        $settings = Setting::all();
        return successResponse(data: [
            'facebook' => $settings->firstWhere('key', 'facebook')->value ?? "",
            'twitter' => $settings->firstWhere('key', 'twitter')->value ?? "",
            'snapchat' => $settings->firstWhere('key', 'snapchat')->value ?? "",
            'instagram' => $settings->firstWhere('key', 'instagram')->value ?? "",

            'egyptian_phone' => $settings->firstWhere('key', 'egyptian_phone')->value ?? "",
            'egyptian_whatsapp' => $settings->firstWhere('key', 'egyptian_whatsapp')->value ?? "",
            'saudi_phone' => $settings->firstWhere('key', 'saudi_phone')->value ?? "",
            'saudi_whatsapp' => $settings->firstWhere('key', 'saudi_whatsapp')->value ?? "",
        ]);
    }
}
