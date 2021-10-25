<?php

namespace App\Modules\Hero\Domain;

use App\Modules\Base\BaseDto;
use App\Modules\Base\Domain\BaseFilter;
use Illuminate\Validation\Rule;

/**
 * Hero filter
 */
class HeroFilter extends BaseFilter
{
    public function forUpdate(BaseDto $data): bool
    {
        $this->messages = [];
        $this->setBasicRule();
        return $this->basic($data);
    }

    public function forUpdateActive(BaseDto $data): bool
    {
        $this->messages = [];
        $this->rules['active'] = 'required|boolean|numeric';
        return $this->basic($data);
    }

    protected function setBasicRule()
    {
        $this->rules = [
            'image' => 'required|mimes:jpeg,bmp,png|max:10240',
            'url'   => 'nullable|active_url',
            'active'  => 'nullable|boolean|numeric',
        ];
    }
}
