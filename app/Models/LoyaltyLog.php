<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'points',
        'type',
        'store_id',
        'user_id',
    ];
          
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
