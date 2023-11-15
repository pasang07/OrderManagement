<?php

namespace App\Models\Model\SuperAdmin\Amenity;

use Illuminate\Database\Eloquent\Model;
class AmenityGallery extends Model
{
    protected $fillable=['amenity_id','title','image','slug','status','order'];
    protected function getStatusTextAttribute()
    {
    return  ucwords(str_replace( '_', ' ',$this->status));
    }
    public function amenity()
    {
        return $this->belongsTo('App\Models\Model\SuperAdmin\Amenity\Amenity','amenity_id');
    }
}
