<?php

namespace App\Http\Controllers\User;

use Stevebauman\Location\Facades\Location;
use App\Http\Controllers\Controller;

class GeoipController extends Controller
{
    public function index()
    {
        if ($position = Location::get()) {
            return successResponse(data: [
                'name' =>  $position->countryName,
                'country_code' =>  $position->countryCode,
                'phone_code' => $this->getPhoneCode($position->countryCode),
            ]);
        } else {
            return failResponse();
        } 
    }

    function getPhoneCode($countryCode) {
        $phoneCodes = array(
            'EG' => '+20', 
            'SA' => '+966'
        );
        return isset($phoneCodes[$countryCode]) ? $phoneCodes[$countryCode] : null;
      }
}
