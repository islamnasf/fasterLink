<?php

namespace App\Http\Resources;

class ResourceCollectionFactory {

    public static function create(string $type,$resource)
    {
        switch ($type) {
            case 'join':
                return  StoreRequestCollection::make($resource);
            default:
                return null;
        }
    }
}