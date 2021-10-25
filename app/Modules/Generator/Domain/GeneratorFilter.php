<?php

namespace App\Modules\Generator\Domain;

use App\Modules\Base\BaseDto;
use App\Modules\Base\Domain\BaseFilter;
use Illuminate\Validation\Rule;

/**
 * Generator filter
 */
class GeneratorFilter extends BaseFilter
{
    public function forUpdate(BaseDto $data): bool
    {
        /*
        $this->messages = [];
        $this->setBasicRule();
        $this->rules['password'] = 'nullable|min:5';
        return $this->basic($data);
        */
    }

    protected function setBasicRule()
    {
        $this->rules = [
            'name'  => 'required|string',
            'email'  => 'required|email',
        ];
    }
}
