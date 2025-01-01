<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'days_period',
        'start_date',
        'end_date',
        'active',
        'image',
        'terms',
        'store_id',
    ];

    protected $casts = [
        'terms' => 'array',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
