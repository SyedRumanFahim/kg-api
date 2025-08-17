<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class NewsContent extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'newsContentAPI';
}
