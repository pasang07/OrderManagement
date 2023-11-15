<?php

namespace App\Http\Controllers\SuperAdmin\Contact;

use App\Http\Requests\SuperAdmin\Contact\MailFormRequest;
use App\Models\Model\SuperAdmin\Contact\Contact;
use App\Models\Model\SuperAdmin\SiteSetting\SiteSetting;
use App\Models\Service\SuperAdmin\Contact\ContactService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Mail;
class ContactController extends Controller
{
    protected $contact;
    function __construct(ContactService $contact)
    {
        $this->contact=$contact;
    }

    public function index()
    {
        $contacts=$this->contact->paginate();
        $show_search='yes';
       return view('super-admin.contact.index',compact('contacts','show_search'));
    }
    public function show($id)
    {
        $contact=Contact::find($id)->firstorFail();
        $show_search='yes';
        DB::table('contacts')->where('id', $id)->update(['is_read' => 'yes']);
        return view('super-admin.contact.mail-detail',compact('contact','show_search'));
    }
    public function destroy($id)
    {
        if($this->contact->delete($id)){
            Toastr::success('Contact deleted successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('contact.index');
        }else{
            Toastr::error('Problem in deleting contact', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('contact.index');
        }
    }
    public function contactMail(Request $request)
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
        return view('super-admin.contact.mail-form',compact('emails'));
    }
    public function contactMailSend(MailFormRequest $request)
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
        Mail::send('emails.contact-reply-mail',$data,function ($message) use ($data){
            $message->from($data['from'],$data['mail_name']);
            $message->bcc($data['email']);
            $message->subject($data['subject'].' - '.SITE_TITLE);
        });
        Toastr::success('Mail Sent successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('contact.index');
    }
    public function search()
    {
        $contacts=$this->contact->search(str_slug($_GET['key']));
        $show_search='yes';
        return view('super-admin.contact.index',compact('contacts','show_search'));
    }
}
