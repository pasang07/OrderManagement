<?php

namespace App\Models\Model\SuperAdmin\Subscriber;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable=['name','email','order'];
}
