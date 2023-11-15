<?php

namespace App\Models\Model\SuperAdmin\Amenity;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $fillable=['title','slug','content','image','home_image','status','order'];
     protected function getStatusTextAttribute()
     {
         return  ucwords(str_replace( '_', ' ',$this->status));
     }
    public function amenity_faqs()
    {
        return $this->hasMany('App\Models\Model\SuperAdmin\Amenity\AmenityFaq','amenity_id');
    }
    public function amenity_galleries()
    {
        return $this->hasMany('App\Models\Model\SuperAdmin\Amenity\AmenityGallery','amenity_id');
    }
}
