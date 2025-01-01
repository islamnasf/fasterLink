<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'store_id',
        'user_id',
        'reward_type',
        'reward_name',
        'is_used',
        'casher_id',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
