<?php

namespace App\Models;

use Mongodb\Laravel\Eloquent\Model;

class Cart extends Model
{
    protected $connection = 'mongodb';

    protected $fillable = [
        'user_id',
        'items',
        'total_price',
        'status'
    ];

    protected $casts = [
        'items' => 'array'
    ];

}
