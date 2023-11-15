<?php

namespace App\Http\Controllers\SuperAdmin\Reservation;

use App\Http\Requests\SuperAdmin\Subscriber\MailFormRequest;
use App\Models\Model\SuperAdmin\Reservation\Reservation;
use App\Models\Model\SuperAdmin\Reservation\ReservationConfirm;
use App\Models\Model\SuperAdmin\Room\Room;
use App\Models\Service\SuperAdmin\Reservation\ReservationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Kamaln7\Toastr\Facades\Toastr;
use CountryState;

class ReservationController extends Controller
{
    protected $reservation;
    function __construct(ReservationService $reservation)
    {
        $this->reservation=$reservation;
    }
    public function getCalender(){
        $today_date = Carbon::now()->format('Y-m-d');
        $booked_data = Reservation::where('booked_date', $today_date)->orWhere('check_in', $today_date)->where('status', 'active')->orderBy('created_at','desc')->get();
        $confirmed_data = ReservationConfirm::where('check_in', $today_date)->orderBy('check_in','desc')->get()->unique('booking_no');
        $vacant_data = Room::where('status','active')->orderBy('order')->get();
        $countries = CountryState::getCountries();

        return view('super-admin.reservation.calender.accwisecalender', compact('booked_data','confirmed_data','today_date','vacant_data','countries'));
    }
    public function index()
    {
        $reservations=$this->reservation->paginate();
        $show_search='yes';
        return view('super-admin.reservation.index',compact('reservations','show_search'));
    }
    public function destroy($id)
    {
        if($this->reservation->delete($id)){
            Toastr::success('Reservation deleted successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('reservation.index');
        }else{
            Toastr::error('Problem in deleting reservation', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('reservation.index');
        }
    }
    public function reservationMail(Request $request)
    {
        if($request['email']!=''){
            $email=$request['email'];
            $display= '';
            foreach($email as $mail){
                $display=$display.$mail.",";
            }
            $total_display = trim($display,",");
            $emails=$total_display;
        }
        else{
            $emails='';
        }
        return view('super-admin.reservation.mail-form',compact('emails'));
    }
    public function reservationMailSend(MailFormRequest $request)
    {
        if($request['to']!=''){
            $email=$request['to'];
            $display= '';
            foreach($email as $mail){
                $display=$display.$mail.",";
            }
            $total_display = trim($display,",");
            $emails=(explode(",",$total_display));;
        }
        $data=array(
            'from'=>SITE_MAIL_EMAIL,
            'email'=>$emails,
            'subject'=>$request->subject,
            'content'=>$request->message,
        );
        Mail::send('emails.subscriber-mail',$data,function ($message) use ($data){
            $message->from($data['from']);
            $message->to($data['email']);
            $message->subject($data['subject']);
        });
        Toastr::success('Mail Sent successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('reservation.index');
    }
    public function search()
    {
        $reservations=$this->reservation->search(str_slug($_GET['key']));
        $show_search='yes';
        return view('super-admin.reservation.index',compact('reservations','show_search'));
    }
}
