<?php

namespace App\Modules\MapHistory\Interfaces;

use App\Models\MapHistory;
use App\Modules\MapHistory\Request\MapHistoryRequest;

interface IMapHistoryDecorator
{
    public function All();
    public function UpsertMapHistory(MapHistoryRequest $request, MapHistory $MapHistory = null);
    public function Get(int $id);
    public function Delete(int $id);
}
