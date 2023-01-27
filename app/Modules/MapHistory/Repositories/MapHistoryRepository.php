<?php

namespace App\Modules\MapHistory\Repositories;

use App\Models\MapHistory;
use App\Repositories\BaseRepository;

class MapHistoryRepository extends BaseRepository
{
    protected $model;

    public function __construct(MapHistory $MapHistory)
    {
        parent::__construct($MapHistory);
    }
}
