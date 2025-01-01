<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'basic_price',
        'discount',
        'price',
        'image',
        'store_id',
        'department_id',
        'attributes',
        'active',
    ];

    protected $casts = [
        'attributes' => 'array',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
