<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JneDestination extends Model
{
    protected $table = 'jne_destinations';
    public $timestamps = false;
    protected $fillable = ['code', 'name', 'city', 'province'];
}