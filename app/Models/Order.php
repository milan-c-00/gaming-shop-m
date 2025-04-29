<?php

namespace App\Models;

use Mongodb\Laravel\Eloquent\Model;

class Order extends Model
{

    protected $connection = 'mongodb';

    protected $fillable = [
        'user_id',
        'items',
        'total_price',
        'status',
        'payment_method',
    ];

}
