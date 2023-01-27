<?php

namespace App\Modules\City\Repositories;

use App\Models\City;
use App\Repositories\BaseRepository;

class CityRepository extends BaseRepository
{
    protected $model;

    public function __construct(City $City)
    {
        parent::__construct($City);
    }
}
