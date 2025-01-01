<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoinRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_name',
        'city_id',
        'phone',
    ];
        
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
