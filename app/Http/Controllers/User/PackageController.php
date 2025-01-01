<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\PackageCollection;
use App\Models\Package;

class PackageController extends Controller
{
    public function get()
    {
        $packages = Package::all();
        return successResponse(data:PackageCollection::collection($packages));
    }

    public function index()
    {
        $packages = Package::all();
        return successResponse(data:PackageCollection::collection($packages));
    }

}
