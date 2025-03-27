<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
class Test extends Model
{
    protected $connection = 'mongodb';
    protected $fillable = ['text', 'number'];
}
