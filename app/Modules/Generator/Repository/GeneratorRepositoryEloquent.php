<?php

namespace App\Modules\Generator\Repository;

use App\Modules\Generator\Generator;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class GeneratorRepositoryEloquent extends BaseRepository implements GeneratorRepositoryInterface
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
        return Generator::class;
    }
}
