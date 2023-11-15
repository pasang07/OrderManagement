<?php

namespace App\Models\Model\SuperAdmin\Amenity;

use Illuminate\Database\Eloquent\Model;

class AmenityQuery extends Model
{
    protected $fillable=['name','email','phone','service_id','service_name','quote','demo','info','is_read','order'];
}
