<?php

namespace App\Http\Controllers\SuperAdmin\Subscriber;

use App\Http\Requests\SuperAdmin\Subscriber\MailFormRequest;
use App\Models\Model\SuperAdmin\SiteSetting\SiteSetting;
use App\Models\Service\SuperAdmin\Subscriber\SubscriberService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Mail;
class SubscriberController extends Controller
{
    protected $subscriber;
    function __construct(SubscriberService $subscriber)
    {
        $this->subscriber=$subscriber;
    }

    public function index()
    {
        $subscribers=$this->subscriber->paginate();
        $show_search='yes';
       return view('super-admin.subscriber.index',compact('subscribers','show_search'));
    }
    public function destroy($id)
    {
        if($this->subscriber->delete($id)){
            Toastr::success('Subscriber deleted successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('subscriber.index');
        }else{
            Toastr::error('Problem in deleting subscriber', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('subscriber.index');
        }
    }
    public function subscriberMail(Request $request)
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
        return view('super-admin.subscriber.mail-form',compact('emails'));
    }
    public function subscriberMailSend(MailFormRequest $request)
    {
        $site_data = SiteSetting::find(1);
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
            'from'=>SITE_EMAIL,
            'email'=>$emails,
            'subject'=>$request->subject,
            'content'=>$request->message,
            'mail_name'=>$site_data->title,
        );
        Mail::send('emails.subscriber-mail',$data,function ($message) use ($data){
            $message->from($data['from'],$data['mail_name']);
            $message->bcc($data['email']);
            $message->subject($data['subject']);
        });
        Toastr::success('Mail Sent successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('subscriber.index');
    }
    public function search()
    {
        $subscribers=$this->subscriber->search(str_slug($_GET['key']));
        $show_search='yes';
        return view('super-admin.subscriber.index',compact('subscribers','show_search'));
    }
}
