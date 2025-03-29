<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
class Product extends Model
{

    protected $connection = 'mogodb';

    protected $fillable = [
        'name',
        'category',
        'price',
        'stock',
        'description',
        'platform',
        'images',
        'release_date'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'release_date' => 'date'
    ];

}
