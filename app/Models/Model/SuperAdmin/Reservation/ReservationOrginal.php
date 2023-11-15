<?php

namespace App\Models\Model\SuperAdmin\Reservation;

use Illuminate\Database\Eloquent\Model;

class ReservationOrginal extends Model
{
    protected $fillable=['customer_id','booking_no','name','email','phone','message','country','bookfor','guest_name','guest_email','room_id','room_name','room_price','adult','child','booked_date','check_in_date','check_out_date','stay_length','hire_car','breakfast','stay_guest','unread','hold','confirm','booking_method','status','order'
    ];
    protected function getStatusTextAttribute()
    {
        return  ucwords(str_replace( '_', ' ',$this->status));
    }
    public function trip()
    {
        return $this->belongsTo('App\Models\Model\SuperAdmin\Accomodation\Accomodation','accomodation_id');
    }
}
