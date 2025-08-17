<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class NewsGallery extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'galleryAPI';
}
