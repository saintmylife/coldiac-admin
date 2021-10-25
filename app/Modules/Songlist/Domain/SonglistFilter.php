<?php

namespace App\Modules\Songlist\Domain;

use App\Modules\Base\BaseDto;
use App\Modules\Base\Domain\BaseFilter;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;

/**
 * Songlist filter
 */
class SonglistFilter extends BaseFilter
{
    public function forUpdate(BaseDto $data): bool
    {
        $this->messages = [];
        $this->setBasicRule();
        $this->rules['thumb'] = 'nullable|mimes:jpeg,bmp,png|dimensions:ratio=1/1|max:10240';
        return $this->basic($data);
    }

    public function forUpdateOrder(BaseDto $data): bool
    {
        $this->messages = [];
        $this->rules['order'] = 'required|numeric|gt:0|unique:songlists,order';
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
            'name'  => 'required',
            'thumb' => 'required|mimes:jpeg,bmp,png|dimensions:ratio=1/1|max:10240',
            'url'   => 'required|active_url',
            'active' => 'nullable|boolean|numeric',
            'order' => 'nullable|numeric'
        ];
    }
}
