<?php

namespace App\Modules\Hero;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $fillable = ['image', 'url', 'active'];
}
