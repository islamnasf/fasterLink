<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasherWalletLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'points',
        'previous_points',
        'type',
        'points_source',
        'store_id',
        'user_id',
    ];
          
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
