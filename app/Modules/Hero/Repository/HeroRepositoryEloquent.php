<?php

namespace App\Modules\Hero\Repository;

use App\Modules\Hero\Hero;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class HeroRepositoryEloquent extends BaseRepository implements HeroRepositoryInterface
{

    protected $fieldSearchable = [];

    public function boot()
    {
        $this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Hero::class;
    }
}
