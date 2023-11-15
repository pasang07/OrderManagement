<?php

namespace App\Http\Controllers\FrontEnd\Reservation;

use App\Http\Requests\FrontEnd\Reservation\ReservationRequest;
use App\Models\Model\SuperAdmin\IntroSetting\IntroSetting;
use App\Models\Model\SuperAdmin\Package\Package;
use App\Models\Model\SuperAdmin\Reservation\Reservation;
use App\Models\Model\SuperAdmin\Reservation\ReservationConfirm;
use App\Models\Model\SuperAdmin\Room\Room;
use App\Models\Model\SuperAdmin\Seo\Seo;
use App\Models\Model\SuperAdmin\SiteSetting\SiteSetting;
use App\Models\Service\SuperAdmin\Reservation\ReservationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\DbHelper as DbHelper;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class ReservationController extends Controller
{
    protected $reservation;
    function __construct(ReservationService $reservation)
    {
        $this->reservation=$reservation;
    }

    public function searchAvailability(Request $request){
        //date in format of Y-m-d
        $check_In = Carbon::parse($request->get('check_in'))->format('Y-m-d');
        $check_Out = Carbon::parse($request->get('check_out'))->format('Y-m-d');

        $start = $request->get('check_in');
        $end = $request->get('check_out');
        $length_of_stay = $request->get('night_no');
        $adult = $request->get('adult_no');
        $child = $request->get('child_no');

        $data['reserved_rooms'] = ReservationConfirm::where(function($query) use ($check_In,$check_Out){
                $query->whereBetween('check_in', [$check_In,$check_Out])
                    ->orWhere('check_out','>=', $check_In)
                    ->where('check_in','<=', $check_In);
            })->get();

        $data['available_rooms'] = Room::where('status', 'active')->orderBy('order', 'asc')->get();
        return view('front-end.reservation.index', $data, compact('start', 'end','check_In', 'check_Out', 'length_of_stay', 'adult', 'child'));
    }
    public function roomReservation(Request $request){
        $form = $request->all();
        $formValue=  array();
        parse_str($form['formdata'], $formValue);

        $data['checkIn'] = $request->checkIn;
        $data['checkOut'] = $request->checkOut;
        $data['adult_number'] =  $request->adult_number;
        $data['child_number'] = $request->child_number;
        $data['night'] = $request->night;
        $data['selectedRoomId'] = $request->selectedRoomId;
        $data['totalRoom'] =$request->totalRoom;
        $data['totalPrice'] = $request->totalPrice;
        $data['countedRoom'] = $request->countedRoom;
        $data['priceFormat'] = $request->priceFormat;

        return $data;
    }
    public function confirmReservation(){
        return view('front-end.reservation.confirm-reservation');
    }

    public function reservationFinal(ReservationRequest $request)
    {
        $eachRoom = $request->get('roomName');
        $eachRoomId = $request->get('roomId');
        $eachRoomPr = $request->get('eachroomPrice');
        $eachRoomPrFormat = $request->get('eachroomPriceFormat');
        $adultNumber= $request->get('adultNumber');
        $childNumber = $request->get('childNumber');

        foreach($eachRoom as $key=>$roomnames){
            $allValues[] = [$roomnames,$eachRoomPr[$key], $eachRoomPrFormat[$key], $eachRoomId[$key], $adultNumber[$key],  $childNumber[$key]];
        }
//        dd($allValues);
        $booking_number = substr(base_convert(sha1(uniqid(mt_rand())),16,36),0,5);

        foreach($allValues as $val){
            $room_name_value = $val[0];
            $room_price_value = $val[1];
            $room_price_format = $val[2];
            $room_name_id = $val[3];
            $adultNum = $val[4];
            $childNum = $val[5];

            $data=array(
                'booking_number'=>$booking_number,
                'room_id'=>$room_name_id,
                'room_title'=>$room_name_value,
                'adult_no'=>$request->adult_no,
                'child_no'=>$request->child_no,
                'booked_date'=>$request->booked_date,
                'check_in'=>$request->check_in,
                'check_out'=>$request->check_out,
                'stay_length'=>$request->stay_length,
                'price_format'=>$room_price_format,
                'price_per_room'=>$room_price_value,
                'total_price'=>$room_price_value * $request->get('stay_length'),
                'name'=>$request->name,
                'from'=>$request->email,
                'country'=>$request->country,
                'contact_no'=>$request->phone,
                'identity_no'=>$request->identity_no,
                'content'=>$request->message,
            );
            $reservationInfo = new Reservation();
            $reservationInfo->booking_no = $booking_number;
            $reservationInfo->room_id = $room_name_id;
            $reservationInfo->room_title = $room_name_value;
            $reservationInfo->name = $request->get('name');
            $reservationInfo->email = $request->get('email');
            $reservationInfo->country = $request->get('country');
            $reservationInfo->contact_no = $request->get('phone');
            $reservationInfo->identity_no = $request->get('identity_no');
            $reservationInfo->message = $request->get('message');
            $reservationInfo->booked_date = $request->get('booked_date');
            $reservationInfo->check_in = $request->get('check_in');
            $reservationInfo->check_out = $request->get('check_out');
            $reservationInfo->stay_length = $request->get('stay_length');
            $reservationInfo->total_adult_no = $request->adult_no;
            $reservationInfo->total_child_no = $request->child_no;
            $reservationInfo->adult = $adultNum;
            $reservationInfo->child = $childNum;
            $reservationInfo->price_format = $room_price_format;
            $reservationInfo->per_price = $room_price_value;
            $reservationInfo->tot_price = $room_price_value * $request->get('stay_length');

            if( $reservationInfo->save()){
                Mail::send('emails.room-reservation-mail',$data,function ($message) use ($data){
                    $message->from($data['from']);
                    $message->to(SITE_MAIL_EMAIL);
                $message->bcc([SITE_FIRST_MAIL_EMAIL,SITE_SEC_MAIL_EMAIL]);
                    $message->subject('New Room Reservation - '. SITE_TITLE);
                });
            }
        }
                return view('front-end.reservation.confirm-message');
    }

}
