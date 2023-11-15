<?php

namespace App\Models\Model\SuperAdmin\Rating;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable=['trip_id','name','images','email','address','reviews','rate','status','order'];
}
