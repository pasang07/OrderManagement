<?php

namespace App\Models\Model\SuperAdmin\Banner;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable=['title','slug','content','image','status','order'];
     protected function getStatusTextAttribute()
     {
         return  ucwords(str_replace( '_', ' ',$this->status));
     }
}
