<?php

namespace App\Http\Services;


class RequestService
{
    public static function getLanguage()
    {
        return request()->header('Accept-Language') ?? 'en';
    }
}
