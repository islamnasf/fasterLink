<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Storage;

class LoggerService
{
    public static function storage($data)
    {
        $log_path = 'public/test/log_test.txt';
        $date = date('Y-m-d H:i:s');
        Storage::append($log_path,"-----date-----($date)-----");
        Storage::append($log_path,$data);
    }
}
