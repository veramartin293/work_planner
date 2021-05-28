<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uniform extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'legend',
        'number',
        'size'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
