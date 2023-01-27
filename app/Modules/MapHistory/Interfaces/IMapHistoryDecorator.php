<?php

namespace App\Modules\MapHistory\Interfaces;

use App\Models\MapHistory;
use App\Modules\MapHistory\Request\MapHistoryRequest;

interface IMapHistoryDecorator
{
    public function All();
    public function InsertMapHistory( MapHistory $MapHistory = null);
    public function Get(int $id);
}
