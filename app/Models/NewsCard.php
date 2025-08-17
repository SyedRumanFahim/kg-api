<?php

namespace App\Models;
use MongoDB\Laravel\Eloquent\Model;

class NewsCard extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'newsAPI';
}
