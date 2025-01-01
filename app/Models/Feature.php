<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'file',
        'file_type',
        'price',
    ];
}
