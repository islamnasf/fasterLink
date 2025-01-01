<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_ar',
        // 'basic_price_eg',
        // 'multi_branches_price_eg',
        // 'basic_price',
        // 'multi_branches_price',
        'type',
    ];

    public function elements()
    {
        return $this->belongsToMany(Element::class, 'package_elements')
                    ->withTimestamps();
    }
    public function packageCurrencies()
    {
        return $this->hasMany(PackageCurrency::class);
    }
   

}
