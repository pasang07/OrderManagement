<?php

namespace App\Models\Model\SuperAdmin\Reservation;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable=['trip_id','name','arrival_date','departure_date','listing_departure_date','group_size','address','no_of_days','hotel_type','country','email','contact_no','message','status','order',
    'tour_type'];
    protected function getStatusTextAttribute()
    {
        return  ucwords(str_replace( '_', ' ',$this->status));
    }
    public function trip()
    {
        return $this->belongsTo('App\Models\Model\SuperAdmin\Trip\Trip','trip_id');
    }
}
