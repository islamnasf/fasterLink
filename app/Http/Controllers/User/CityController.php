<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CityRequest;
use App\Http\Resources\CityCollection;
use App\Models\Country;

class CityController extends Controller
{
    public function index(CityRequest $request)
    {
        $country = Country::find($request->country_id);
        if ($country) {
            return successResponse(data: CityCollection::collection($country->cities));
        }
        return failResponse('Country not found');
    }
}
