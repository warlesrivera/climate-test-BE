<?php

namespace App\Models;

use App\Models\City;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MapHistory extends Model
{
    use HasFactory;
    const API_KEY = 'e0747514d5f27693d0331f725e844e45';
    const URL = 'https://api.openweathermap.org/data/3.0/onecall';

    protected $fillable = [
        'humidity',
        'alerts',
        'weather',
        'user_id',
        'city_id'
    ];


    protected $casts = [
        'alerts' => 'array',
        'weather'=>'array'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

}
