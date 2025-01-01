<?php

namespace App\Http\Shared;

use Illuminate\Support\Facades\Storage;

class ImageService
{

    public static function save($request, $folderName, $fieldName = 'image')
    {
        if ($request->hasFile($fieldName)) {
            $fileName = time() . $request->file($fieldName)->getClientOriginalName();
            $location = env('APP_ENV') == 'local' ? "public/$folderName" : $folderName;
            $request->{$fieldName}->storeAs($location, $fileName);
            $path = "storage/$folderName/$fileName";
            return $path;
        }
        return null;
    }

    public static function saveArray($request, $folderName, $fieldName = 'images')
    {
        if ($request->hasFile($fieldName)) {
            $images_array = [];
            $images = $request->file($fieldName);
            foreach ($images as $image) {
                $fileName = time() . $image->getClientOriginalName();
                $location = env('APP_ENV') == 'local' ? "public/$folderName" : $folderName;
                $path = "storage/$folderName/$fileName";
                $image->storeAs($location, $fileName);
                $images_array[] = $path;
            }
            return $images_array;
        }
        return null;
    }
    public static function delete($path)
    {
        Storage::delete(str_replace('storage', 'public', $path));
    }
    public static function url($path)
    {
        return ($path) ? (env('APP_ENV') == 'local' ? url($path) : secure_url($path)) : null;
    }
    public static function path($url)
    {
        return ($url) ? str_replace(env('APP_ENV') == 'local' ? url('/') . '/' : secure_url('/') . '/', '', $url) : null;
    }
    public static function urls($paths)
    {
        if (empty($paths)) {
            return null;
        }
        $data = [];
        foreach ($paths as $path) {
            $data[] = env('APP_ENV') == 'local' ? url($path) : secure_url($path);
        }
        return $data;
    }
}
