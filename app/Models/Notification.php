<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'type',
        'user_id',
        'is_read',
        'app',
        'relatable_type',
        'relatable_id',
    ];

    public function relatable()
    {
        return $this->morphTo();
    }
}
