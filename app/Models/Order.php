<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $hidden = [
        'updated_at',
        'created_at'
    ];

    protected $casts = [
        'is_in_progress' => 'boolean'
    ];
}
