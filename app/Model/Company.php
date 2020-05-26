<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $connection = 'system';

    protected $fillable = [
        'prefix',
    ];
}
