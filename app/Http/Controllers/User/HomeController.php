<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getPanel(Request $request)
    {
        $features = Feature::all();
        return successResponse(data: [
            'network' => $features->first(),
            'features' => $features->whereIn('id', [2, 3, 4])->values()->toArray(),
            'nfc' => $features->whereIn('id', [5, 6, 7])->values()->toArray(),
        ]);
    }
}
