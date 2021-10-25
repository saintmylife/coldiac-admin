<?php

namespace App\Modules\Auth\Domain;

use App\Modules\Base\BaseDto;
use App\Modules\Base\Domain\BaseFilter;

/**
 * Auth filter
 */
class AuthFilter extends BaseFilter
{
    public function forChangePassword(BaseDto $data): bool
    {
        $this->messages = [];
        $this->rules = [
            'password' => 'required',
            'new_password' => 'confirmed|min:6|different:password'
        ];
        return $this->basic($data);
    }

    public function forLogin(BaseDto $data): bool
    {
        return $this->forInsert($data);
    }

    protected function setBasicRule()
    {
        $this->rules = [
            'username' => 'required|min:5',
            'password' => 'required|min:5',
        ];
    }
}
