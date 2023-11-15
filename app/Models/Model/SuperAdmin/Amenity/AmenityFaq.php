<?php

namespace App\Models\Model\SuperAdmin\Amenity;

use Illuminate\Database\Eloquent\Model;
class AmenityFaq extends Model
{
    protected $fillable=['question','slug','amenity_id','answer','status','order'];
    protected function getStatusTextAttribute()
    {
    return  ucwords(str_replace( '_', ' ',$this->status));
    }
    public function amenity()
    {
        return $this->belongsTo('App\Models\Model\SuperAdmin\Amenity\Amenity','amenity_id');
    }
}
