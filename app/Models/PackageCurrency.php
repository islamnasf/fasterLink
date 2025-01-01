<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageCurrency extends Model
{
    use HasFactory;
    protected $fillable = [
        'package_id',
        'currency_id',
        'basic_price',
        'multi_branches_price',
    ];

    /**
     * Relation with Package.
     */
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * Relation with Currency.
     */
    public function currency()
    {
        return $this->belongsTo(currency::class);
    }
}
