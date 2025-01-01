<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_ar',
        'url',
        'image',
        'store_id',
        'link_type_id',
        'active',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function linkType()
    {
        return $this->belongsTo(LinkType::class);
    }
}
