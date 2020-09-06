<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    protected $fillable = ['name', 'type', 'lat', 'lng', 'addr', 'tel', 'stock_information'];
}
