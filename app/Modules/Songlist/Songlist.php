<?php

namespace App\Modules\Songlist;

use Illuminate\Database\Eloquent\Model;

class Songlist extends Model
{
    protected $fillable = ['name', 'thumb', 'url', 'active', 'order'];
}
