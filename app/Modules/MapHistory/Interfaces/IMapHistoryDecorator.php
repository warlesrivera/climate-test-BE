<?php

namespace App\Modules\MapHistory\Interfaces;

use App\Models\MapHistory;

interface IMapHistoryDecorator
{
    public function All();
    public function InsertMapHistory( MapHistory $MapHistory = null);
    public function history(int $id, int $size);
}
