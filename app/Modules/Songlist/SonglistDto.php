<?php

namespace App\Modules\Songlist;

use App\Modules\Base\BaseDto;

class SonglistDto extends BaseDto
{
    protected $id;
    protected $name;
    protected $thumb;
    protected $url;
    protected $active;
    protected $order;
}
