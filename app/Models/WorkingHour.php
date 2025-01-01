<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'day',
        'periods',
        'is_working',
        'branch_id',
    ];
          
    protected $casts = [
        'periods' => 'array',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

}
