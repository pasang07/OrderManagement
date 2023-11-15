<?php

namespace App\Models\Model\SuperAdmin\Reservation;

use Illuminate\Database\Eloquent\Model;

class ReservationConfirm extends Model
{
    protected $fillable=['room_id','room_title','booking_no','name','email','phone','country','content','check_in','check_out','adult_no','child_no','stay_length','room_price'];

}
