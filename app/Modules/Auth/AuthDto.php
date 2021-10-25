<?php

namespace App\Modules\Auth;

use App\Modules\Base\BaseDto;

/**
 * Auth DTO
 */
class AuthDto extends BaseDto
{
    protected $name;
    protected $username;
    protected $password;
    protected $new_password;
    protected $new_password_confirmation;
}
