<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\PackageCollection;
use App\Models\Package;

class PackageController extends Controller
{
    public function get()
    {
        $packages = Package::with(['packageCurrencies.currency','elements'])->get();
        // return successResponse(data:PackageCollection::collection($packages));
        return successResponse(data:$packages);

    }

    public function index()
    {
        $packages = Package::with(['packageCurrencies.currency','elements'])->get();
        // return successResponse(data:PackageCollection::collection($packages));
        return successResponse(data:$packages);

    }

}
