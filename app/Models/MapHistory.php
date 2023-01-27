<?php

namespace App\Models;

use App\Models\Alerts;
use App\Models\Wather;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MapHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'humidity',
        'alerts',
        'weather',
        'user_id'
    ];

    protected $casts = [
        'alerts' => Alerts::class,
        'weather' => Wather::class
    ];
}
