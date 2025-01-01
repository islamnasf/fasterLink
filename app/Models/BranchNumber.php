<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'type',
        'number',
        'branch_id',
    ];
          
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

}