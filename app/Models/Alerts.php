<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerts extends Model
{
    use HasFactory;

    protected $fillable = [
      'sender_name',
      'event',
      'start',
      'end',
      'description'
    ];
}
