<?php

namespace App\Models\Model\SuperAdmin\Reservation;

use Illuminate\Database\Eloquent\Model;

class ReservationRelease extends Model
{
    protected $fillable=['released_date','released_by','released_reason','customer_id',
        'booking_no','name','email','phone','country','room_id','room_name','room_price','adult','child',
        'booked_date','check_in_date','check_out_date','stay_length'
    ];
}
