<?php

namespace App\Http\Controllers\SuperAdmin\Reservation;

use App\Models\Model\SuperAdmin\Reservation\ReservationCheckout;
use App\Models\Model\SuperAdmin\Room\Room;
use App\Models\Model\SuperAdmin\Room\RoomNo;
use App\Models\Model\SuperAdmin\Reservation\Reservation;
use App\Models\Model\SuperAdmin\Reservation\ReservationConfirm;
use App\Models\Model\SuperAdmin\Reservation\ReservationOrginal;
use App\Models\Model\SuperAdmin\Reservation\ReservationRelease;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use CountryState;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class AccomodationwiseCalenderController extends Controller
{
    public function index($id)
    {
        $today_date = Carbon::now()->format('Y-m-d');
        $booked_data = Reservation::where('booked_date', $today_date)->orWhere('check_in', $today_date)->where('status', 'active')->orderBy('created_at','desc')->get();
        $confirmed_data = ReservationConfirm::where('check_in', $today_date)->orderBy('check_in','desc')->get()->unique('booking_no');
        $vacant_data = Room::where('status','active')->orderBy('order')->get();
        $countries = CountryState::getCountries();

        return view('super-admin.reservation.calender.accwisecalender', compact('booked_data','confirmed_data','today_date','vacant_data','countries'));
    }
    public function getCalender(){
        $today_date = Carbon::now()->format('Y-m-d');
        $booked_data = Reservation::where('booked_date', $today_date)->orWhere('check_in', $today_date)->where('status', 'active')->orderBy('created_at','desc')->get();
        $confirmed_data = ReservationConfirm::where('check_in', $today_date)->orderBy('check_in','desc')->get()->unique('booking_no');
        $vacant_data = Room::where('status','active')->orderBy('order')->get();
        $countries = CountryState::getCountries();

        return view('super-admin.reservation.calender.accwisecalender', compact('booked_data','confirmed_data','today_date','vacant_data','countries'));
    }

    public function getAll(Request $request){
        $clickedDate= $request->get('selectedDate');
        $clickedDateAfter= $request->get('checkOut');
        $bookingList = '';
        $confirmed = '';
        $reservationLists = Reservation::where('booked_date', $clickedDate)->orWhere('check_in', $clickedDate)->orderBy('created_at','desc')->get();
        if($reservationLists->count()>0){
            foreach($reservationLists as $k=>$reservation){
                $j=0;
                $bookingList  .= '<tr id="'.$k.$j.'"><td>'.$reservation->name.'</td>';
                $bookingList .='<td>'.wordwrap($reservation->room_title, 30 ,"\n<br>").'</td>';
                $bookingList .=  '<td>';
                //Booking Confirm Button
                $bookingList .=  '<button class="btn btn-info btn-sm confirmed"  checkIn="'.$reservation->check_in.'" checkOut="'.$reservation->check_out.'" value="1" room_id ="'.$reservation->room_id.'"  room_name = "'.$reservation->room_title.'" trow_id="'.$k.$j.'" reservation_id = "'.$reservation->id.'" onclick="confirm()" style="line-height: 0.8;padding: 7px;margin-right: 3px;">Confirm</button>';
                //Booking Release Button
                $bookingList .=  '<button class="btn btn-danger btn-sm booking_release" style="line-height: 0.8;padding: 7px;margin-right: 0;" booking_no="'.$reservation->booking_no.'" room_id ="'.$reservation->room_id.'"  trow_releaseId="'.$k.$j.'" onclick="bookingReleaseModal('.$reservation->id.')">Cancel</button>
                                 </td></tr>';
                $j++;
            }
        }
        else{
            $bookingList .="<tr><td colspan='4'>Sorry! No Bookings for this day.</td></tr>";
        }

        $confirmed_room = RoomNo::where('check_in',$clickedDate)->where('confirm','yes')->get();
        $confirmed_reservation = ReservationConfirm::where('check_in', $clickedDate)->orderBy('check_in','desc')->get()->unique('booking_no');

        //if room is booked
        if($confirmed_reservation->count()>0){
            foreach($confirmed_reservation as $k=>$confirmed_reservations){
                $confirmed .= '
                                <tr id="confirmedRow'.$confirmed_reservations->id.'">
                                <input type="hidden" id="b_no" value="'.$confirmed_reservations->booking_no.'">
                               <td class="text-uppercase">'.$confirmed_reservations->booking_no.'</td>
                               <td>'.wordwrap($confirmed_reservations->name,28,"<br />\n", false).'</td>';
                $confirmed .=  '<td><button class="btn btn-info btn-sm" style="line-height: 0.8;padding: 7px;" booking_no="'.$confirmed_reservations->booking_no.'"  onclick="confirmDetails('.$confirmed_reservations->id.')">Check Out</button></td></tr>';
            }
        }
        else{
            $confirmed .= '<tr><td colspan="3">No Rooms Were Confirmed</td></tr>';
        }
        $vacant_room = '';

        $allRoom = Room::where('status', 'active')->orderBy('order')->get();
        foreach($allRoom as $k=>$roomInfo){
            $start =  Carbon::parse($request->get('selectedDate'))->format('Y-m-d');
            $end =   $clickedDateAfter;
            $allRoom_selectedDate = RoomNo::where('room_id',$roomInfo->id)->orderBy('order')->get()->count();

            $reservedRoomCount = Reservation::where('room_id',$roomInfo->id)
                ->where(function($query) use ($start,$end){
                    $query->whereBetween('check_in', [$start,$end])
                        ->orWhere('check_out','>=', $start)
                        ->where('check_in','<=', $start);
                })->get()->count();

            $confirmedRoomCount = ReservationConfirm::where('room_id',$roomInfo->id)
                ->where(function($query) use ($start,$end){
                    $query->whereBetween('check_in', [$start,$end])
                        ->orWhere('check_out','>=', $start)
                        ->where('check_in','<=', $start);
                })->get()->count();

            $a = $reservedRoomCount + $confirmedRoomCount;
            $v = $allRoom_selectedDate  - $a;

            if($v == 1){
                $roomNum = '<span class="noRoom"> Only 1 room left </span> ';
            }elseif($v == 0) {
                $roomNum = '<span class="noRoom"> Sorry!! No room left. </span> ';
            }
            else{
                $roomNum = $v.' rooms';
            }
            if($v == 0){
                $btnD = 'disabled style="cursor: not-allowed;"';
            }
            else{
                $btnD = '';
            }
            $vacant_room.= '<tr><td>'.wordwrap($roomInfo->title,30,"<br />\n", false).'</td>';
            $vacant_room.= '<td><button class="btn btn-primary btn-sm vacant" trow_id="'.$k.'"  room_id ="'.$roomInfo->id.'" room_title ="'.$roomInfo->title.'" onclick="vacant()" '.$btnD.'>Walk in (Direct)</button>
                                <button class="btn btn-secondary btn-sm manual" trow_id="'.$k.'"  room_id ="'.$roomInfo->id.'" room_title ="'.$roomInfo->title.'" onclick="manual()" '.$btnD.'>Manual</button>
                            </td></tr>';
        }

        $response =[
            'clickedDate' => date('l, d F Y', strtotime($clickedDate)),
            'bookingList' => $bookingList,
            'confirmed' => $confirmed,
            'vacant_room' => $vacant_room,
        ];
        return response()->json($response);
    }

    public function ajaxBookingModal(Request $request)
    {
        $room_name = $request->get('room_name');
        $roomId = $request->get('room_id');
        $room_detail = Room::where('id',$roomId)->first();
        $checkIn = $request->get('checkIn');
        $checkOut = $request->get('checkOut');
        $value = $request->get('values');
        $reservation_id = $request->get('reservation_id');
        $reservation_detail = Reservation::where('id',$reservation_id)->first();
        $trow_id = $request->get('trow_id');

        //data adding to room assigning modal
        $roomno = '';
        $roomno .='<input type="hidden" id="reservation_id" value="'.$reservation_id.'" data="'.$trow_id.'">
        <input type="hidden" id="trow_id" value="'.$trow_id.'" >
                  <div class="row">
                      <div class="col-md-12 text-center acc">
                      <h4 style="margin-bottom: 2px;text-transform: uppercase;">'.$room_detail->title.'</h4>
                      </div>
                  <div class="col-md-12">
                        <h5 class="cust">Customer Details</h5>
                         <div class="row" style="padding:5px;">
                         <div class="col-md-6">
                         <p class="text-uppercase">Booking Number#: <span style="color:red;">'.$reservation_detail->booking_no.'</span></p>
                         <p>Name: '.$reservation_detail->name.'</p>
                         <p>Email: '.$reservation_detail->email.'</p>
                         </div>
                         <div class="col-md-6">
                         <p>Country: '.$reservation_detail->country.'</p>
                         <p>Phone: '.$reservation_detail->contact_no.'</p>
                         </div>
                         <div class="col-12">
                         <p>Special Request:<br>'.$reservation_detail->message.'</p>
                         </div>
                         </div>
                 </div>
                 <div class="col-md-12 mt-2">
                    <h5 class="cust">Booking Informations</h5>
                     <div class="row" style="padding:5px;">
                          <div class="col-md-6"><div class="form-group">
                          <label style="margin-bottom: .5rem;">Check-In Date:&nbsp;&nbsp;</label>&nbsp;<br>
                          <input type="text" class="form-control" id="checkin" name="check-in" style="" value="'.$checkIn.'" readonly>
                          </div></div>
                          <div class="col-md-6"><div class="form-group">
                          <label style="margin-bottom: .5rem;">Check-In Date:&nbsp;&nbsp;</label>&nbsp;<br>
                          <input type="text" class="form-control" id="checkout" style=""  name="check-out" value="'.$checkOut.'" readonly>
                          </div></div>
                          <div class="col-md-12"><div class="form-group">
                          <label style="margin-bottom: .5rem;">Selected Room:&nbsp;&nbsp;</label>&nbsp;<br>
                          <input type="text" class="form-control" style="" id="selectedroom" value="'.$room_name.'" readonly>
                          </div></div>
                          <div class="col-md-6"><div class="form-group">
                          <label style="margin-bottom: .5rem;">Adult Number:&nbsp;&nbsp;</label>&nbsp;<br>
                          <input type="text" class="form-control" value="'.$reservation_detail->adult.'" readonly>
                          </div></div>
                          <div class="col-md-6"><div class="form-group">
                          <label style="margin-bottom: .5rem;">Child:&nbsp;&nbsp;</label>&nbsp;<br>
                          <input type="text" class="form-control" value="'.$reservation_detail->child.'" readonly>
                          </div></div>
                     </div>
                 </div>
                 </div>';

        $start =  Carbon::parse($request->get('checkIn'))->format('Y-m-d');
        $end =  Carbon::parse($request->get('checkOut'))->format('Y-m-d');

        $allRoom_selectedDate = RoomNo::where('room_id',$roomId)->get();
        $roomno .= '<div class="row" style="padding: 5px;"><div class="col-md-12 mb-3"><h6>Room No:</h6></div>';

        foreach($allRoom_selectedDate as $all){
            $confirmedRoom = ReservationConfirm::where('room_no_id', $all->id)
                ->where(function($query) use ($start,$end){
                    $query->whereBetween('check_in', [$start,$end])
                        ->orWhere('check_out','>=', $start)
                        ->where('check_in','<=', $start);
                })->get();

            if ($confirmedRoom->count()>0){
                $occupiedRoom_selectedDate = RoomNo::where('id',  $all->id)->where('room_id',$roomId)->get();
                if(!$occupiedRoom_selectedDate){
                    $roomno .= '<div class="col-md-6 mb-3"><div class="row"><div class="col-md-3"><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input"  name="room_no" value="' . $all->id . '" id="roomCode' . $all->id . '" onchange="checkRoom('.$roomId.')"> <label class="custom-control-label"  for="roomCode' . $all->id . '">' . $all->title . '</label></div></div><div class="col-md-7"></div></div></div>';
                }
                else{
                    $roomno .= '';
                }
            }
            else{
                $roomno .= '<div class="col-md-6 mb-3"><div class="row"><div class="col-md-3"><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input"  name="room_no" value="' . $all->id . '" id="roomCode' . $all->id . '" onchange="checkRoom('.$roomId.')"> <label class="custom-control-label"  for="roomCode' . $all->id . '">' . $all->title . '</label></div></div><div class="col-md-7"></div></div></div>';
            }
        }
        $roomno .= '</div>';
        return $roomno;
    }

    //showing adult and child select option when roomnNo is checked
    public function checkPeople(Request $request){
        $room_id = $request->get('room_id');
        $max_adult = Room::where('id', $room_id)->first()->adult;
        $max_child = Room::where('id', $room_id)->first()->children;
        $option = '';
        $option .='<div class="row"><div class="col-md-6"><label>Adult</label><select name = "adult" class="form-control">';
        for($i=1; $i<=$max_adult; $i++ ){
            $option .='<option value="'.$i.'"';
            if($i == $max_adult){$option .='selected';}
            $option .='>'.$i.'</option>';
        }
        $option .='</select></div>';
        $option .='<div class="col-md-6"><label>Child</label><select name = "child" class="form-control">';
        for($j=0; $j<=$max_child; $j++ ){
            $option .='<option value="'.$j.'"';
            if($j == 0){$option .='selected';}
            $option .='>'.$j.'</option>';
        }
        $option .='</select></div>';
        $option .='</div>';
        return $option;
    }

    public function confirmBooking(Request $request)
    {
        $checked_room = $request->get('checked_roomCode');
        $roomType = $request->get('roomType');
        $reservation_id = $request->get('reservation_id');

        //Inserting data to confirm reservation table
        $reservation_details = Reservation::where('id',$reservation_id)->first();

        foreach ($checked_room as $checked_roomCodes) {
            $room_name = RoomNo::where('id',$checked_roomCodes)->first();
            $eachroom_price = Room::where('id',$room_name->room_id)->first()->price;
            $eachroom_price_format = Room::where('id',$room_name->room_id)->first()->price_format;
            
            $data=array(
                'booking_number'=>$reservation_details->booking_no,
                'room_title'=>$roomType,
                'adult_no'=>$reservation_details->adult,
                'child_no'=>$reservation_details->child,
                'booked_date'=>$reservation_details->booked_date,
                'check_in'=>$reservation_details->check_in,
                'check_out'=>$reservation_details->check_out,
                'stay_length'=>$reservation_details->stay_length,
                'price_format'=>$eachroom_price_format,
                'price_per_room'=>$eachroom_price,
                'total_price'=>$eachroom_price * $reservation_details->stay_length,
                'name'=>$reservation_details->name,
                'from'=>$reservation_details->email,
                'country'=>$reservation_details->country,
                'contact_no'=>$reservation_details->contact_no,
                'identity_no'=>$reservation_details->identity_no,
                'content'=>$reservation_details->message,
            );
            
            $confirm_reservation_details = new ReservationConfirm();
            $confirm_reservation_details->room_no_id = $checked_roomCodes;
            $confirm_reservation_details->room_name = $roomType;
            $confirm_reservation_details->room_id = $room_name->room_id;
            $confirm_reservation_details->room_no = $room_name->title;
            $confirm_reservation_details->booking_no = $reservation_details->booking_no;
            $confirm_reservation_details->name = $reservation_details->name;
            $confirm_reservation_details->email = $reservation_details->email;
            $confirm_reservation_details->phone = $reservation_details->contact_no;
            $confirm_reservation_details->identity_no = $reservation_details->identity_no;
            $confirm_reservation_details->country = $reservation_details->country;
            $confirm_reservation_details->message = $reservation_details->message;
            $confirm_reservation_details->check_in = $reservation_details->check_in;
            $confirm_reservation_details->check_out = $reservation_details->check_out;
            $confirm_reservation_details->adult_no = $reservation_details->adult;
            $confirm_reservation_details->child_no = $reservation_details->child;
            $confirm_reservation_details->stay_length = $reservation_details->stay_length;
            $confirm_reservation_details->room_price = $eachroom_price;
            $confirm_reservation_details->price_format = $eachroom_price_format;

            if($confirm_reservation_details->save()){
                Mail::send('emails.room-confirmation-mail',$data,function ($message) use ($data){
                    $message->from(SITE_MAIL_EMAIL);
                    $message->to($data['from']);
                    $message->bcc([SITE_FIRST_MAIL_EMAIL]);
                    $message->subject('Room Reservation Confirmation - '. SITE_TITLE);
                });
            }
        }

        //For deleting data in booked tab after confirming details
        Reservation::where('id',$reservation_id)->delete();

    }

    //showing modal data from confirmed details button
    public function confirmedDetailModal(Request $request){
        $booking_no = $request->get('booking_no');
        $trow_id = $request->get('row_id');
        $confirmId = $request->get('confirmId');

        $details = ReservationConfirm::where('id',$confirmId)->first();

        if($details->child_no == 0){
            $cld = '';
        }else{
            $cld = ' & '.$details->child_no. ' Child';
        }
        $confirmList = ReservationConfirm::where('booking_no', $details->booking_no)->get();
        $totalAdult= $confirmList->sum('adult_no');
        $totalChild= $confirmList->sum('child_no');
        $totalPrice= $confirmList->sum('room_price');

        if($totalChild == 0){
            $totChild = '';
        }else{
            $totChild = '& ' .$totalChild . ' Child';
        }

        if($details->bookfor =="other"){
            $d = '<tr><td class="text-uppercase">Booked For:</td></tr>';
            $guest_Name = '<tr><td>'.$details->guest_name.'</td></tr>';
            $guest_Email = '<tr><td>'.$details->guest_email.'</td></tr>';
        }
        else{
            $d='';
            $guest_Name = '';
            $guest_Email = '';
        }
        $confirmedDetails = '';

        $confirmedDetails .='<div class="row">
                                <div class="col-md-12 text-center acc">
                                <h4 style="margin-bottom: 2px;text-transform: uppercase;">'.$details->room_name.'</h4>
                                <hr width ="100%">
                            </div>
                            <div id="printTable" class="col-md-12">
                                <div class="card" style="box-shadow: none;">
                                    <div class="row invoice-contact mb-0 p-0">
                                        <div class="col-md-6">
                                        <div class="invoice-box row">
                                            <div class="col-sm-12">
                                             <input type="hidden" id="trow_id" value="'.$trow_id.'" >
                                            <table class="table table-responsive invoice-table table-borderless p-2">
                                            <tbody>
                                            <tr><td class="text-uppercase">Booked By:</td></tr>
                                            <tr><td><b>'.$details->name.'</b></td></tr>
                                            <tr><td>'.$details->phone.', '.$details->email.'</td></tr>
                                            <tr><td>'.$details->country.'</td></tr>
                                            </tbody>
                                            </table>
                                            </div>               
                                        </div>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <table class="table table-responsive invoice-table table-borderless p-2">
                                            <tbody>
                                            '.$d.'
                                            '.$guest_Name.'
                                            '.$guest_Email.'
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-block p-2">
                                        <div class="row invoive-info mb-2">
                                            <div class="col-md-6 col-sm-6">
                                                <h6 class="m-b-10">Booking Information:</h6>
                                                <table class="table table-responsive invoice-table invoice-order table-borderless">
                                                            <tbody>
                                                            <tr><th>Check In: </th><td>'.date("l, d F Y", strtotime($details->check_in)).'</td></tr>
                                                            <tr><th>Check Out: </th><td>'.date("l, d F Y", strtotime($details->check_out)).'</td></tr>
                                                            <tr><th>Length of stay: </th><td>'.$details->stay_length.' night</td></tr>
                                                            </tbody>
                                                        </table>
                                            </div>
                                            <div class="col-md-6 col-sm-6 text-right">
                                                <h6></h6>
                                                <h6 class="m-b-20 text-uppercase">Booking No#: <span>'.$details->booking_no.'</span></h6>
                                                <h6 class="m-b-20">Total Room(s): <span>'.$confirmList->count().' Rooms</span></h6>
                                                <h6 class="m-b-20">Total Guest(s): <span>'.$totalAdult.' Adult '.$totChild.'</span></h6>
                                            </div>
                                        </div>';
        if($details->message){
            $confirmedDetails .='<div class="row">
                                            <div class="col-sm-12">
                                            <h5 class="pb-2">Customer Special Requirements:</h5>
                                            <p>'.$details->message.'</p>
                                            </div>
                                        </div>';
        }
        $confirmedDetails .='<div class="row">
                                            <div class="col-sm-12">
                                            <h5 class="cust">Room Informations</h5>
                                                <div class="table-responsive">
                                                    <table class="table invoice-detail-table">
                                                    <thead>
                                                    <tr class="thead-default">
                                                    <th>S.N</th><th>Room Name</th><th>Room No</th><th>Guest(s)</th><th>Room Price</th><th>Total Room Price</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>';
        foreach($confirmList as $s=>$cl) {
            $sn = $s + 1;
            $tp = $cl->room_price * $details->stay_length;
            $confirmedDetails .= '<tr>';
            $confirmedDetails .='<td>'.$sn.'</td>';
            $confirmedDetails .='<td>' . wordwrap($cl->room_name, 25, "\n<br>") . '</td>';
            $confirmedDetails .= '<td>' . $cl->room_no . '</td>';
            $confirmedDetails .= '<td>' . $cl->adult_no . ' Adult' . $cld . '</td>';
            $confirmedDetails .= '<td>' . $details->price_format.$cl->room_price . ' (per night)</td>';
            $confirmedDetails .= '<td>' . $details->price_format.$tp . ' (for '.$details->stay_length.' night)</td>';
            $confirmedDetails .= '</tr>';
        }
        $op = $totalPrice * $details->stay_length;
        $confirmedDetails .='</tbody></table>
                             </div><span style="display: none;" id="price_now">'.$details->price_format.$op.'</span></div>
                             </div>';
        $overallPrice = $totalPrice;

        $confirmedDetails .='<div class="row">
                                <div class="col-sm-12">
                                <table class="table table-responsive invoice-table invoice-total">
                                    <tbody>
                                    <tr>
                                    <td><h6 class="text-uppercase text-primary">Room Price (including vat & tax) : <span id="price_now">'.$details->price_format.number_format((float)$op, 2, '.', '').'</span></h6>
                                    <hr width="100%" style="background: #a2a3a5;">
                                    <h5 class="text-uppercase text-primary">Overall Price : <span id="price_after">'.$details->price_format.number_format((float)$op, 2, '.', '').'</span></h5></td>
                                    </tr>
                                    </tbody>
                                </table>
                                </div>
                             </div>
                             </div></div>
                            </div></div>
                        <input type="hidden" id="booking_no" value="'.$booking_no.'" >';

        return $confirmedDetails;
    }

    public function listConfirm(Request $request){

        $booking_no = $request->get('booking_no');
        $confirmList = ReservationConfirm::where('booking_no', $booking_no)->get();
        foreach($confirmList as $confirm){

            $reservationCheckout = new ReservationCheckout();
            $reservationCheckout->booking_no = $confirm->booking_no;
            $reservationCheckout->room_id = $confirm->room_id;
            $reservationCheckout->room_name = $confirm->room_name;
            $reservationCheckout->room_no = $confirm->room_no;
            $reservationCheckout->room_no_id = $confirm->room_no_id;
            $reservationCheckout->name = $confirm->name;
            $reservationCheckout->email = $confirm->email;
            $reservationCheckout->phone = $confirm->phone;
            $reservationCheckout->country = $confirm->country;
            $reservationCheckout->message = $confirm->message;
            $reservationCheckout->adult_no = $confirm->adult_no;
            $reservationCheckout->child_no = $confirm->child_no;
            $reservationCheckout->check_in = $confirm->check_in;
            $reservationCheckout->check_out = $confirm->check_out;
            $reservationCheckout->stay_length = $confirm->stay_length;
            $reservationCheckout->price_format = $confirm->price_format;
            $reservationCheckout->room_price = $confirm->room_price;
            $reservationCheckout->total_price = $confirm->room_price * $confirm->stay_length;
            $reservationCheckout->save();

            $confirm->delete();
        }
    }

    public function bookingreleaseModal(Request $request){
        $trow_id = $request->get('row_id');

        $room_id = $request->get('room_id');
        $room_detail = Room::where('id', $room_id)->first();

        $reservationId = $request->get('reservationId');
        $booking_no = $request->get('booking_no');

        $releasedBy =Auth::user()->name;
        $pw =Auth::user()->password;

        $releaseRoom = '';
        $releaseRoom .='<input type="hidden" id="reservation_id" value="'.$reservationId.'">
                        <input type="hidden" id="trow_id" value="'.$trow_id.'" >
                        <input type="hidden" id="booking_no" value="'.$booking_no.'" >
                        <input type="hidden" id="room_id" value="'.$room_id.'" >
                        <input type="hidden" id="real_password" value="'.$pw.'" >
                        <div class="row">
                            <div class="col-md-12 text-center acc">
                              <h4 style="margin-bottom: 2px;text-transform: uppercase;">'.$room_detail->title.'</h4>
                            </div>
                            <div class="col-md-12">
                                <h5 class="cust">Reason to cancel room</h5>
                                 <div class="row" style="padding:5px;">
                                      <div class="col-md-12 form-group">
                                         <label for="content">Reason <span class="text-danger">*</span> </label>
                                         <textarea class="form-control" id="release_reason" placeholder="Why do you release this room?" rows="12" style="height: 100px;" onkeyup="removeReleaseReasonError()"></textarea>
                                        <span class="text-danger" id="releaseReasonErr"></span>
                                      </div>
                                     <div class="col-md-12 form-group">
                                     <label for="released_by"> Cancelled By:</label>
                                     <input type="text" name="released_by" class="form-control" id="released_by" value="'.$releasedBy.'" readonly>
                                     </div>
                                     <div class="col-md-12 form-group">
                                     <label for="account_password"> Your Account Password <span class="text-danger">*</span> </label>
                                     <input type="password" name="account_password" class="form-control" id="account_password" placeholder="Type password" onkeyup="removeAccountPasswordError()">
                                     <span class="text-danger" id="accountPasswordErr"></span>
                                     </div>
                                 </div>
                            </div>
                        </div>';
        return $releaseRoom;
    }

    public function releaseConfirm(Request $request){

        $reservationId = $request->get('reservationId');
        $bookingNo = $request->get('bookingNo');
        $roomId = $request->get('roomId');
        $releaseReason = $request->get('releaseReason');
        $releasedBy = $request->get('releasedBy');
        $realPw = $request->get('realPw');
        $accountPw = $request->get('accountPw');

        if(!Hash::check($accountPw,$realPw)) {
            return 1;
        }else{
            $reservation_details = Reservation::where('id',$reservationId)->first();
            $releasedDetails = new ReservationRelease();
            $releasedDetails->released_date = Carbon::now()->format('Y-m-d');
            $releasedDetails->released_by = $releasedBy;
            $releasedDetails->released_reason = $releaseReason;
            $releasedDetails->customer_id = $reservation_details->customer_id;
            $releasedDetails->booking_no = $reservation_details->booking_no;
            $releasedDetails->name = $reservation_details->name;
            $releasedDetails->email = $reservation_details->email;
            $releasedDetails->phone = $reservation_details->phone;
            $releasedDetails->country = $reservation_details->country;
            $releasedDetails->room_id = $reservation_details->room_id;
            $releasedDetails->room_name = $reservation_details->room_title;
            $releasedDetails->price_format = $reservation_details->price_format;
            $releasedDetails->room_price = $reservation_details->per_price;
            $releasedDetails->adult = $reservation_details->adult;
            $releasedDetails->child = $reservation_details->child;
            $releasedDetails->booked_date = $reservation_details->booked_date;
            $releasedDetails->check_in_date = $reservation_details->check_in;
            $releasedDetails->check_out_date = $reservation_details->check_out;
            $releasedDetails->stay_length = $reservation_details->stay_length;
            $releasedDetails->save();

            Reservation::where('id',$reservationId)->delete();
        }
    }

    //direct booking modal
    public function ajaxVacantModal(Request $request)
    {
        $accomodation_id = $request->get('accomodation_id');
        $accomodation_detail = Accomodation::where('id', $accomodation_id)->first();
        $trow_id = $request->get('trow_id');
        $roomId = $request->get('room_id');
        $roomPrice = AccomodationRoom::where('id', $roomId)->first()->price;
        $maxCapacity = AccomodationRoom::where('id', $roomId)->first()->adult;
        $roomTitle = $request->get('room_title');
        $countries = CountryState::getCountries();
        $countryName = '';
        $countryName .= '<select class="form-control" id="country_name" name="country" onchange="removeCountryError()">
                         <option value="">--Select Country--</option>';
        foreach ($countries as $country) {
            $countryName .='<option value="'. $country.'">' . $country . '</option>';
        }
        $countryName .='</select>';

        $start =  Carbon::parse($request->get('checkIn'))->format('Y-m-d');
        $end =  Carbon::parse($request->get('checkOut'))->format('Y-m-d');

        $totalRooms = AccomodationRoomNo::where('accomodation_id', $accomodation_id)
            ->where('room_id',$roomId)->orderBy('order')->get()->count();

        $reservedRooms = Reservation::where('accomodation_id',$accomodation_id)->where('room_id',$roomId)
            ->where(function($query) use ($start,$end){
                $query->whereBetween('check_in_date', [$start,$end])
                    ->orWhere('check_out_date','>=', $start)
                    ->where('check_in_date','<=', $start);
            })->get()->count();

        $confirmedRooms = ReservationConfirm::where('accomodation_id',$accomodation_id)->where('room_id',$roomId)
            ->where(function($query) use ($start,$end){
                $query->whereBetween('check_in_date', [$start,$end])
                    ->orWhere('check_out_date','>=', $start)
                    ->where('check_in_date','<=', $start);
            })->get()->count();

        $r = $reservedRooms + $confirmedRooms;
        $remainingRooms = $totalRooms  - $r;
        $requiredRoomSelect = '';
        $requiredRoomSelect .='<select class="form-control mt-2" id="requiredRoomNumber" onchange="maxGuest('.$maxCapacity.')">
                         <option value="">--How many rooms do you need?--</option>';;
        for($i=1; $i<=$remainingRooms; $i++){
            $requiredRoomSelect .= '<option value="'. $i.'">' . $i . '</option>';
        }
        $requiredRoomSelect .='</select>';

        $remRoomNos = '';
        if($remainingRooms == 0){
            $remRoomNos .='';
        }else if($remainingRooms == 1){
            $remRoomNos .= 'You have only 1 room left.';
        }
        else{
            $remRoomNos .= 'You have '. $remainingRooms. ' rooms available.';
        }
        $roomNos = '';
        if($reservedRooms == 0){
            $roomNos .= '';
        }
        else if($reservedRooms == 1){
            $roomNos .= 'NOTE: 1 room is reserved but not confirmed. '. $remRoomNos;
        }else{
            $roomNos .= 'NOTE: '.$reservedRooms.' rooms are reserved but not confirmed. '.$remRoomNos;
        }

        //booking form for vacant modal
        $roomno = '';
        $roomno .= '<input type="hidden" data="' . $trow_id . '"><input type="hidden" id="trow_id" value="' . $trow_id . '" >
                  <div class="row">
                      <div class="col-md-12 text-center acc">
                      <input type="hidden" id="accommodationID" value ="'.$accomodation_id.'">
                      <input type="hidden" id="roomID" value ="'.$roomId.'">
                      <h4 style="margin-bottom: 2px;text-transform: uppercase;">' . $accomodation_detail->title . '</h4>
                      <span>' . $accomodation_detail->address . '</span>
                      </div>
                  <div class="col-md-12">
                        <h5 class="cust">Customer Details</h5>
                         <div class="row" style="padding:5px;">
                             <div class="col-md-6 form-group">
                             <label for="name">Your Name <span class="text-danger">*</span> </label>
                             <input type="text" name="name" class="form-control" id="name" placeholder="Full Name" onkeyup="removeNameError()">
                             <span class="text-danger" id="nameErr"></span></div>
                             <div class="col-md-6 form-group">
                             <label for="email">Email Address <span class="text-danger">*</span> </label>
                             <input type="text" class="form-control" name="email" id="email_id" placeholder="Email" onkeyup="removeEmailError()">
                             <span class="text-danger" id="emailErr"></span>
                             </div>
                             <div class="col-md-4 form-group">
                             <label for="email">Where are you from?<span class="text-danger"> *</span> </label>
                             '.$countryName.'
                             <span class="text-danger" id="countryErr"></span></div>
                             <div class="col-md-4 form-group">
                             <label for="country_code">ISD Code/ Country Code<span class="text-danger"> *</span> </label>
                             <input type="text" name="country_code" class="form-control" id="country_code" placeholder="Example for Nepal: +977"  onkeyup="removeIsoError()">
                             <span class="text-danger" id="isoErr"></span></div>
                             <div class="col-md-4 form-group">
                             <label for="phone">Contact No.<span class="text-danger"> *</span> </label>
                             <input type="text" name="phone" class="form-control" id="phone" placeholder=" Your Phone Number" onkeyup="removeContactError()">
                             <span class="text-danger" id="contactErr"></span></div>
                             <div class="col-md-12 form-group">
                             <label for="content">Special Request(If Any)</label>
                             <textarea name="message" class="form-control" id="message" placeholder=" Your Special Requirements" rows="12" style="height: 100px;"></textarea>
                             </div>
                             <div class="col-md-12 form-group">
                             <label for="hiringcar">
                             <input id="hiringcar" type="checkbox" name="car" value="yes"> &nbsp;I am interested in renting a car.<br>
                             <small>Make the most out of your trip and check car hire options in your booking confirmation.</small>
                             </label>
                             </div>
                     </div>
                 </div>
                 <div class="col-md-12 mb-3">
                    <h5 class="cust">Room Details</h5>
                    <div class="row" style="padding:5px;">
                    <div class="col-md-4">
                    <p>Room Name: </p>
                    <p>Room Capacity: </p>
                    <p>Per Room Price: </p>
                    </div>
                    <div class="col-md-8">
                    <p><span id="selectedroom">'.$roomTitle.'</span></p>
                    <p>Maximum <span id="guest_capacity">'.$maxCapacity.'</span> guest</p>
                    <p><span id="perRoom_price">'.$roomPrice.'</span><span style="display:none;" id="perRoom_price_after">'.$roomPrice.'</span></p>
                    </div>
                    </div>
                 </div>
                 <div class="col-md-12">
                    <h5 class="cust">Booking Summary</h5>
                     <div class="row" style="padding:5px;">
                          <div class="col-md-6"><div class="form-group">
                          <label style="margin-bottom: .5rem;">Check-In Date:&nbsp;&nbsp;</label>&nbsp;<br>
                          <input id="flatpicker" type="text" name="checkInDate" class="form-control" disabled>
                          </div></div>
                          <div class="col-md-6"><div class="form-group">
                          <label style="margin-bottom: .5rem;">Check-Out Date:&nbsp;&nbsp;</label>&nbsp;<br>
                          <input id="flatpicker1" type="text" name="checkOutDate" class="form-control" room_id = "'.$roomId.'" accomodation_id = "'.$accomodation_id.'">
                          <span style="display: none;" id="night_no_single">1</span>
                          </div></div>
                          <input type="hidden" class="form-control" id="total_guest_capacity" name="total_guest_capacity" value="'.$maxCapacity.'">
                          <div class="col-md-12"><div class="form-group">
                          <label style="margin-bottom: .5rem;">Total Number of Room(s):&nbsp;&nbsp;</label><br>
                          <div id="direct_room">
                          <input type="text" class="form-control mb-2" value="'.$remainingRooms.' rooms available." readonly>
                          <small class="text-info">'.$roomNos.'</small>
                          '.$requiredRoomSelect.'
                          </div></div></div>
                          <div class="col-md-12"><div class="form-group">
                          <label style="margin-bottom: .5rem;">Total Room Price (For <span id="staying_length"> 1 Night</span>):&nbsp;&nbsp;</label>&nbsp;<br>
                          <input type="number" class="form-control" id="totRoomPrice" value="'.$roomPrice.'" readonly>
                          </div></div>
                     </div>
                 </div></div>';

        $allRoom_selectedDate = AccomodationRoomNo::where('accomodation_id', $accomodation_id)->where('room_id',$roomId)->get();

        $roomno .= '<div class="row" style="padding: 5px;"><div class="col-md-12"><h6>Available Rooms:</h6></div></div><div id="avl_rooms" class="row" style="padding: 5px;">';

        foreach($allRoom_selectedDate as $all){
            $confirmedRoom = ReservationConfirm::where('room_no_id', $all->id)
                ->where(function($query) use ($start,$end){
                    $query->whereBetween('check_in_date', [$start,$end])
                        ->orWhere('check_out_date','>=', $start)
                        ->where('check_in_date','<=', $start);
                })
                ->where('accomodation_id', $accomodation_id)->get();

            if ($confirmedRoom->count()>0){
                $occupiedRoom_selectedDate = AccomodationRoomNo::where('id',  $all->id)->where('accomodation_id', $accomodation_id)->where('room_id',$roomId)->get();
                if(!$occupiedRoom_selectedDate){
                    $roomno .= '<div class="col-md-6 mb-3"><div class="row"><div class="col-md-3"><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input"  name="room_num" value="' . $all->id . '" id="roomCode' . $all->id . '" onclick="checkRoomCode('.$roomId.')"> <label class="custom-control-label"  for="roomCode' . $all->id . '">' . $all->title . '</label></div></div><div class="col-md-7"></div></div></div>';
                }
                else{
                    $roomno .= '';
                }
            }
            else{
                $roomno .= '<div class="col-md-6 mb-3"><div class="row"><div class="col-md-3"><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input"  name="room_num" value="' . $all->id . '" id="roomCode' . $all->id . '" onclick="checkRoomCode('.$roomId.')"> <label class="custom-control-label"  for="roomCode' . $all->id . '">' . $all->title . '</label></div></div><div class="col-md-7"></div></div></div>';
            }
        }
        $roomno .= '</div>';
        return $roomno;
    }

    public function vacantRoomAvailable(Request $request){
        $accomodation_id = $request->get('accomodation_id');
        $roomId = $request->get('room_id');
        $maxCapacity = AccomodationRoom::where('id', $roomId)->first()->adult;

        $start =  Carbon::parse($request->get('checkinDate'))->format('Y-m-d');
        $end =  Carbon::parse($request->get('checkoutDate'))->format('Y-m-d');

        $totalRooms = AccomodationRoomNo::where('accomodation_id', $accomodation_id)
            ->where('room_id',$roomId)->orderBy('order')->get()->count();

        $reservedRooms = Reservation::where('accomodation_id',$accomodation_id)->where('room_id',$roomId)
            ->where(function($query) use ($start,$end){
                $query->whereBetween('check_in_date', [$start,$end])
                    ->orWhere('check_out_date','>=', $start)
                    ->where('check_in_date','<=', $start);
            })->get()->count();

        $confirmedRooms = ReservationConfirm::where('accomodation_id',$accomodation_id)->where('room_id',$roomId)
            ->where(function($query) use ($start,$end){
                $query->whereBetween('check_in_date', [$start,$end])
                    ->orWhere('check_out_date','>=', $start)
                    ->where('check_in_date','<=', $start);
            })->get()->count();

        $r = $reservedRooms + $confirmedRooms;
        $remainingRooms = $totalRooms  - $r;
        $requiredRoomSelect = '';
        $requiredRoomSelect .='<select class="form-control mt-2" id="requiredRoomNumber" onchange="maxGuest('.$maxCapacity.')">
                         <option value="">--How many rooms do you need?--</option>';;
        for($i=1; $i<=$remainingRooms; $i++){
            $requiredRoomSelect .= '<option value="'. $i.'">' . $i . '</option>';
        }
        $requiredRoomSelect .='</select>';

        $remRoomNos = '';
        if($remainingRooms == 0){
            $remRoomNos .='';
        }else if($remainingRooms == 1){
            $remRoomNos .= 'You have only 1 room left.';
        }
        else{
            $remRoomNos .= 'You have '. $remainingRooms. ' rooms options.';
        }
        $roomNos = '';
        if($reservedRooms == 0){
            $roomNos .= '';
        }
        else if($reservedRooms == 1){
            $roomNos .= 'NOTE: 1 room is reserved but not confirmed. '. $remRoomNos;
        }else{
            $roomNos .= 'NOTE: '.$reservedRooms.' rooms are reserved but not confirmed. '.$remRoomNos;
        }

        $roomno = '';
        $roomno .= '<input type="text" class="form-control mb-2" value="'.$remainingRooms.' rooms available." readonly>
                    <small class="text-info">'.$roomNos.'</small>
                    '.$requiredRoomSelect;
        return $roomno;
    }

    public function vacantConfirmModal(Request $request){

        $roomcode_adultChild = $request->get('roomcode_adultChild');

        $booking_number = substr(base_convert(sha1(uniqid(mt_rand())),16,36),0,5);

        foreach($roomcode_adultChild as $rac){
            $room_no = AccomodationRoomNo::where('id',$rac[0])->first()->title;
            $confirmDetails = new ReservationConfirm();
            $confirmDetails->accomodation_id = $request->get('accomodation_id');
            $confirmDetails->room_id = $request->get('room_id');
            $confirmDetails->room_name = $request->get('roomName');
            $confirmDetails->room_no_id = $rac[0];
            $confirmDetails->room_no =$room_no ;
            $confirmDetails->booking_no =$booking_number;
            $confirmDetails->name =$request->get('name');
            $confirmDetails->email =$request->get('email');
            $confirmDetails->phone =$request->get('countryCode'). '-'.$request->get('contact');
            $confirmDetails->country =$request->get('country');
            $confirmDetails->message =$request->get('specialRequest');
            $confirmDetails->bookfor ='yourself';
            $confirmDetails->adult_no =$rac[1];
            $confirmDetails->child_no =$rac[2];
            $confirmDetails->check_in_date =$request->get('checkIn') ;
            $confirmDetails->check_out_date =$request->get('checkOut') ;
            $confirmDetails->room_price =$request->get('roomPrice');
            $confirmDetails->stay_length =$request->get('length');
            $confirmDetails->hire_car =$request->get('hireCar');
            $confirmDetails->status ='active';
            $confirmDetails->save();

            //saving in reservation original table

            $orginalDetails = new ReservationOrginal();
            $orginalDetails->accomodation_id = $request->get('accomodation_id');
            $orginalDetails->booking_no =$booking_number;
            $orginalDetails->name =$request->get('name');
            $orginalDetails->email =$request->get('email');
            $orginalDetails->phone =$request->get('countryCode'). '-'.$request->get('contact');
            $orginalDetails->country =$request->get('country');
            $orginalDetails->message =$request->get('specialRequest');
            $orginalDetails->bookfor ='yourself';
            $orginalDetails->guest_name = NULL;
            $orginalDetails->guest_email = NULL;
            $orginalDetails->room_id = $request->get('room_id');
            $orginalDetails->room_name = $request->get('roomName');
            $orginalDetails->room_price =$request->get('roomPrice');
            $orginalDetails->booked_date =$request->get('checkIn');
            $orginalDetails->check_in_date =$request->get('checkIn');
            $orginalDetails->check_out_date =$request->get('checkOut');
            $orginalDetails->stay_length =$request->get('length');
            $orginalDetails->adult =$rac[1];
            $orginalDetails->child =$rac[2];
            $orginalDetails->hire_car =$request->get('hireCar');
            $orginalDetails->booking_method ='walk';
            $orginalDetails->status ='active';
            $orginalDetails->save();
        }
    }

    //manual booking
    public function ajaxManualModal(Request $request)
    {
        $accomodation_id = $request->get('accomodation_id');
        $accomodation_detail = Accomodation::where('id', $accomodation_id)->first();
        $trow_id = $request->get('trow_id');
        $roomId = $request->get('room_id');
        $roomPrice = AccomodationRoom::where('id', $roomId)->first()->price;
        $maxCapacity = AccomodationRoom::where('id', $roomId)->first()->adult;
        $roomTitle = $request->get('room_title');
        $countries = CountryState::getCountries();
        $manualCountryName = '';
        $manualCountryName .= '<select class="form-control" id="manual_country_name" name="manual_country_name" onchange="removeManualCountryError()">
                         <option value="">--Select Country--</option>';
        foreach ($countries as $country) {
            $manualCountryName .='<option value="'. $country.'">' . $country . '</option>';
        }
        $manualCountryName .='</select>';

        $start =  Carbon::parse($request->get('checkIn'))->format('Y-m-d');
        $end =  Carbon::parse($request->get('checkOut'))->format('Y-m-d');

        $totalRooms = AccomodationRoomNo::where('accomodation_id', $accomodation_id)
            ->where('room_id',$roomId)->orderBy('order')->get()->count();

        $reservedRooms = Reservation::where('accomodation_id',$accomodation_id)->where('room_id',$roomId)
            ->where(function($query) use ($start,$end){
                $query->whereBetween('check_in_date', [$start,$end])
                    ->orWhere('check_out_date','>=', $start)
                    ->where('check_in_date','<=', $start);
            })->get()->count();

        $confirmedRooms = ReservationConfirm::where('accomodation_id',$accomodation_id)->where('room_id',$roomId)
            ->where(function($query) use ($start,$end){
                $query->whereBetween('check_in_date', [$start,$end])
                    ->orWhere('check_out_date','>=', $start)
                    ->where('check_in_date','<=', $start);
            })->get()->count();

        $r = $reservedRooms + $confirmedRooms;
        $remainingRooms = $totalRooms  - $r;
        $requiredRoomSelect = '';
        $requiredRoomSelect .='<select class="form-control" id="manual_requiredRoomNumber" name="manual_requiredRoomNumber" onchange="changingRoom('.$roomId.')">
                         <option value="">-- How many rooms do you need? --</option>';;
        for($i=1; $i<=$remainingRooms; $i++){
            $requiredRoomSelect .= '<option value="'. $i.'">' . $i . '</option>';
        }
        $requiredRoomSelect .='</select>';

        //booking form for manual modal
        $roomno = '';
        $roomno .= '<input type="hidden" data="' . $trow_id . '"><input type="hidden" id="trow_id" value="' . $trow_id . '" >
                  <div class="row">
                      <div class="col-md-12 text-center acc">
                      <input type="hidden" id="manual_accommodationID" value ="'.$accomodation_id.'">
                      <input type="hidden" id="manual_roomID" value ="'.$roomId.'">
                      <h4 style="margin-bottom: 2px;text-transform: uppercase;">' . $accomodation_detail->title . '</h4>
                      <span>' . $accomodation_detail->address . '</span>
                      </div>
                  <div class="col-md-12">
                        <h5 class="cust">Customer Details</h5>
                         <div class="row" style="padding:5px;">
                             <div class="col-md-6 form-group">
                             <label for="manual_name">Your Name <span class="text-danger">*</span> </label>
                             <input type="text" name="manual_name" class="form-control" id="manual_name" placeholder="Full Name" onkeyup="removeManualNameError()">
                             <span class="text-danger" id="manualNameErr"></span></div>
                             <div class="col-md-6 form-group">
                             <label for="manual_email_id">Email Address <span class="text-danger">*</span> </label>
                             <input type="text" class="form-control" id="manual_email_id" placeholder="Email" onkeyup="removeManualEmailError()">
                             <span class="text-danger" id="manualEmailErr"></span>
                             </div>
                             <div class="col-md-4 form-group">
                             <label for="manual_country_name">Where are you from?<span class="text-danger"> *</span> </label>
                             '.$manualCountryName.'
                             <span class="text-danger" id="manualCountryErr"></span></div>
                             <div class="col-md-4 form-group">
                             <label for="manual_country_code">ISD Code/ Country Code<span class="text-danger"> *</span> </label>
                             <input type="text" name="manual_country_code" class="form-control" id="manual_country_code" placeholder="Example for Nepal: +977"  onkeyup="removeManualIsoError()">
                             <span class="text-danger" id="manualIsoErr"></span></div>
                             <div class="col-md-4 form-group">
                             <label for="manual_phone">Contact No.<span class="text-danger"> *</span> </label>
                             <input type="text" name="manual_phone" class="form-control" id="manual_phone" placeholder=" Your Phone Number" onkeyup="removeManualContactError()">
                             <span class="text-danger" id="manualContactErr"></span></div>
                             <div class="col-md-12 form-group">
                             <label for="manual_message">Special Request(If Any)</label>
                             <textarea name="manual_message" class="form-control" id="manual_message" placeholder=" Your Special Requirements" rows="12" style="height: 100px;"></textarea>
                             </div>
                             <div class="col-md-12 form-group">
                             <label for="bookingFor">Who are you booking for?</label><br>
                             <label for="yourself">
                             <input id="yourself" type="radio" name="bookingfor" value="yourself" onclick="bookforyourself()">&nbsp; Book for myself</label> &nbsp;&nbsp;&nbsp;
                             <label for="other">
                             <input id="other" type="radio" name="bookingfor" value="other" onclick="bookforother()">&nbsp; Book for someone else</label>
                             </div>
                             <div id="otherbook" style="display:none;" class="col-md-12">
                             <div class="row">
                             <div class="col-md-6 form-group">
                             <label for="manual_guest_name">Full Guest Name <span class="text-danger"> *</span> </label>
                             <input type="text" name="manual_guest_name" class="form-control" id="manual_guest_name" placeholder="Enter Full Name">
                             </div>
                             <div class="col-md-6 form-group">
                             <label for="manual_guest_email">Guest Email (optional)</label>
                             <input type="text" class="form-control" name="manual_guest_email" id="manual_guest_email" placeholder="Guest Email">
                             </div>
                             </div>
                             </div>
                             <div class="col-md-12 form-group">
                             <label for="manual_hiringcar">
                             <input id="manual_hiringcar" type="checkbox" value="yes"> &nbsp;I am interested in renting a car.<br>
                             <small>Make the most out of your trip and check car hire options in your booking confirmation.</small>
                             </label>
                             </div>
                     </div>
                 </div>
                 <div class="col-md-12">
                    <h5 class="cust">Booking Summary</h5>
                     <div class="row" style="padding:5px;">
                          <div class="col-md-12"><div class="form-group">
                          <label style="margin-bottom: .5rem;">Room Title:&nbsp;&nbsp;</label>&nbsp;<br>
                          <input type="text" class="form-control" value="'.$roomTitle.'" readonly>
                          </div></div>
                          <div class="col-md-6"><div class="form-group">
                          <label style="margin-bottom: .5rem;">Check-In Date:&nbsp;&nbsp;</label>&nbsp;<br>
                          <input id="manualflatpicker" type="text" name="checkInDate" class="form-control" disabled>
                          </div></div>
                          <div class="col-md-6"><div class="form-group">
                          <label style="margin-bottom: .5rem;">Check-Out Date:&nbsp;&nbsp;</label>&nbsp;<br>
                          <input id="manualflatpicker1" type="text" name="checkOutDate" class="form-control" room_id = "'.$roomId.'" accomodation_id = "'.$accomodation_id.'">
                          <span style="display: none;" id="manual_night_no_single">1</span>
                          </div></div>
                          <div class="col-md-6"><div class="form-group">
                          <label style="margin-bottom: .5rem;">Total Lenght of Stay:&nbsp;&nbsp;</label>&nbsp;
                          <input id="manual_staying_length" type="text" class="form-control" value="1 Night" readonly>
                          </div></div>
                          <div class="col-md-6"><div class="form-group">
                          <label style="margin-bottom: .5rem;">Total Room Price:&nbsp;&nbsp;</label>&nbsp;<br>
                          <input type="number" class="form-control" id="manual_totRoomPrice" value="'.$roomPrice.'" readonly>
                          </div></div>
                          <span style="display:none;" id="manual_selectedroom">'.$roomTitle.'</span><span style="display:none;" id="manual_perRoom_price">'.$roomPrice.'</span><span style="display:none;" id="manual_per_room_price_after">'.$roomPrice.'</span>
                          <div class="col-md-6"><div class="form-group">
                          <label style="margin-bottom: .5rem;">Total Available Rooms:&nbsp;&nbsp;</label>&nbsp;<br>
                          <input type="text" id="rm" class="form-control" value="'.$remainingRooms.' rooms left." readonly>
                          </div></div><div class="col-md-6"><div class="form-group">
                          <label style="margin-bottom: .5rem;">Total Number of Room(s):&nbsp;&nbsp;</label>
                          <div id="manual_avl_room">
                          '.$requiredRoomSelect.'
                          </div></div></div>
                          <div class="col-md-12" id="selectedRoomOption"></div>
                     </div>
                 </div></div>';
        $roomno .= '</div>';


        return $roomno;
    }

    public function manualRoomAvailable(Request $request){
        $accomodation_id = $request->get('accomodation_id');
        $roomId = $request->get('room_id');

        $start =  Carbon::parse($request->get('checkinDate'))->format('Y-m-d');
        $end =  Carbon::parse($request->get('checkoutDate'))->format('Y-m-d');

        $totalRooms = AccomodationRoomNo::where('accomodation_id', $accomodation_id)
            ->where('room_id',$roomId)->orderBy('order')->get()->count();

        $reservedRooms = Reservation::where('accomodation_id',$accomodation_id)->where('room_id',$roomId)
            ->where(function($query) use ($start,$end){
                $query->whereBetween('check_in_date', [$start,$end])
                    ->orWhere('check_out_date','>=', $start)
                    ->where('check_in_date','<=', $start);
            })->get()->count();

        $confirmedRooms = ReservationConfirm::where('accomodation_id',$accomodation_id)->where('room_id',$roomId)
            ->where(function($query) use ($start,$end){
                $query->whereBetween('check_in_date', [$start,$end])
                    ->orWhere('check_out_date','>=', $start)
                    ->where('check_in_date','<=', $start);
            })->get()->count();

        $r = $reservedRooms + $confirmedRooms;
        $remainingRooms = $totalRooms  - $r;
        $requiredRoomSelect = '';
        $requiredRoomSelect .='<select class="form-control" id="manual_requiredRoomNumber" name="manual_requiredRoomNumber" onchange="changingRoom('.$roomId.')">
                         <option value="">-- How many rooms do you need? --</option>';;
        for($i=1; $i<=$remainingRooms; $i++){
            $requiredRoomSelect .= '<option value="'. $i.'">' . $i . '</option>';
        }
        $requiredRoomSelect .='</select>';

        $roomno = '';
        $roomno .= $requiredRoomSelect;
        $response =[
            'roomno' => $roomno,
            'rem' => $remainingRooms . ' rooms left.',
        ];
        return response()->json($response);
    }

    //showing room options with adult & child select option when roomNo is selected
    public function roomOption(Request $request){

        $roomNumber = $request->get('roomNumber');
        $room_id = $request->get('room_id');
        $roomName = AccomodationRoom::where('id',$room_id)->first()->title;
        $max_adult = AccomodationRoom::where('id', $room_id)->first()->adult;
        $max_child = AccomodationRoom::where('id', $room_id)->first()->children;
        $option = '';
        if($roomNumber == ''){
            $option .='';
        }else{
            $option .='<div class="row"><div class="col-md-12 mb-3 mt-2"><h5 class="cust">Selected Room</h5></div><div class="col-md-1 mb-2">S.N</div><div class="col-md-5 mb-2">Room Name</div><div class="col-md-3 mb-2"> Adult</div><div class="col-md-3 mb-2">Child</div></div>';
            for($m=1; $m<=$roomNumber; $m++){
                $option .='<div class="row">';
                $option .='<div class="col-md-1 mb-2"><h6>'.$m.'</h6></div>';
                $option .='<div class="col-md-5 mb-2"><h6 class="reqRoomName">'.$roomName.'</h6></div>';
                $option .='<div class="col-md-3 mb-2"><select name = "adult" class="form-control">';
                for($i=1; $i<=$max_adult; $i++ ){
                    $option .='<option value="'.$i.'"';
                    if($i == $max_adult){$option .='selected';}
                    $option .='>'.$i.'</option>';
                }
                $option .='</select></div>';
                $option .='<div class="col-md-3 mb-2"><select name = "child" class="form-control">';
                for($j=0; $j<=$max_child; $j++ ){
                    $option .='<option value="'.$j.'"';
                    if($j == 0){$option .='selected';}
                    $option .='>'.$j.'</option>';
                }
                $option .='</select></div>';
                $option .='</div>';
            }
        }
        return $option;
    }

    public function manualConfirmModal(Request $request){

        $room_adult_child = $request->get('room_adult_child');

        $booking_number = substr(base_convert(sha1(uniqid(mt_rand())),16,36),0,5);

        foreach($room_adult_child as $rac){
            $manualReservationDetails = new Reservation();
            $manualReservationDetails->accomodation_id = $request->get('accomodation_id');
            $manualReservationDetails->booking_no =$booking_number;
            $manualReservationDetails->name =$request->get('name');
            $manualReservationDetails->email =$request->get('email');
            $manualReservationDetails->phone =$request->get('countryCode'). '-'.$request->get('contact');
            $manualReservationDetails->country =$request->get('country');
            $manualReservationDetails->message =$request->get('specialRequest');
            $manualReservationDetails->bookfor =$request->get('bookingFor');
            $manualReservationDetails->guest_name =$request->get('guestName');
            $manualReservationDetails->guest_email =$request->get('guestEmail');
            $manualReservationDetails->room_id = $request->get('room_id');
            $manualReservationDetails->room_name = $rac[0];
            $manualReservationDetails->room_price =$request->get('roomPrice');
            $manualReservationDetails->booked_date =Carbon::now()->format('Y-m-d');
            $manualReservationDetails->check_in_date =$request->get('checkIn');
            $manualReservationDetails->check_out_date =$request->get('checkOut') ;
            $manualReservationDetails->stay_length =$request->get('length');
            $manualReservationDetails->adult =$rac[1];
            $manualReservationDetails->child =$rac[2];
            $manualReservationDetails->hire_car =$request->get('hireCar');
            $manualReservationDetails->status ='active';
            $manualReservationDetails->save();

            //saving in reservation original table

            $orginalDetails = new ReservationOrginal();
            $orginalDetails->accomodation_id = $request->get('accomodation_id');
            $orginalDetails->booking_no =$booking_number;
            $orginalDetails->name =$request->get('name');
            $orginalDetails->email =$request->get('email');
            $orginalDetails->phone =$request->get('countryCode'). '-'.$request->get('contact');
            $orginalDetails->country =$request->get('country');
            $orginalDetails->message =$request->get('specialRequest');
            $orginalDetails->bookfor =$request->get('bookingFor');
            $orginalDetails->guest_name = $request->get('guestName');
            $orginalDetails->guest_email = $request->get('guestEmail');
            $orginalDetails->room_id = $request->get('room_id');
            $orginalDetails->room_name = $rac[0];
            $orginalDetails->room_price =$request->get('roomPrice');
            $orginalDetails->booked_date =Carbon::now()->format('Y-m-d');
            $orginalDetails->check_in_date =$request->get('checkIn');
            $orginalDetails->check_out_date =$request->get('checkOut');
            $orginalDetails->stay_length =$request->get('length');
            $orginalDetails->adult =$rac[1];
            $orginalDetails->child =$rac[2];
            $orginalDetails->hire_car =$request->get('hireCar');
            $orginalDetails->booking_method ='manual';
            $orginalDetails->status ='active';
            $orginalDetails->save();
        }
    }

}
