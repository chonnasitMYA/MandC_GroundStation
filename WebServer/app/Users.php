<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Users extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'Users';
}
