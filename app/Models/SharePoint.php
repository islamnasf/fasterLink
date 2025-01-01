<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharePoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'points',
        'code',
        'store_id',
        'user_id',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
