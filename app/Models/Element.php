<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function packages()
    {
        return $this->belongsToMany(Package::class, 'package_elements')
                    ->withTimestamps();
    }
}
