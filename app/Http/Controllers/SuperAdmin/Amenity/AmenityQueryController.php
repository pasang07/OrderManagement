<?php

namespace App\Http\Controllers\SuperAdmin\Amenity;

use App\Http\Requests\SuperAdmin\Amenity\MailFormRequest;
use App\Models\Model\SuperAdmin\Amenity\AmenityQuery;
use App\Models\Model\SuperAdmin\SiteSetting\SiteSetting;
use App\Models\Service\SuperAdmin\Amenity\AmenityQueryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Mail;
class AmenityQueryController extends Controller
{
    protected $amenityQuery;
    function __construct(AmenityQueryService $amenityQuery)
    {
        $this->amenityQuery=$amenityQuery;
    }

    public function index()
    {
        $amenityQueries=$this->amenityQuery->paginate();
        $show_search='yes';
       return view('super-admin.amenity.query.index',compact('amenityQueries','show_search'));
    }
    public function show($id)
    {
        DB::table('amenity_queries')->where('id', $id)->update(['is_read' => 'yes']);

        $amenityQuery=AmenityQuery::where('id', $id)->first();

        return view('super-admin.amenity.query.mail-detail',compact('amenityQuery'));
    }

    public function destroy($id)
    {
        if($this->amenityQuery->delete($id)){
            Toastr::success('Query deleted successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('amenityQuery.index');
        }else{
            Toastr::error('Problem in deleting amenityQuery', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('amenityQuery.index');
        }
    }
    public function amenityQueryMail(Request $request)
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
        return view('super-admin.amenity.query.mail-form',compact('emails'));
    }
    public function amenityQueryMailSend(MailFormRequest $request)
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
        Mail::send('emails.service-request-reply-mail',$data,function ($message) use ($data){
            $message->from($data['from'],$data['mail_name']);
            $message->bcc($data['email']);
            $message->subject($data['subject'].' - '.SITE_TITLE);
        });
        Toastr::success('Mail Sent successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('amenityQuery.index');
    }
    public function search()
    {
        $amenityQueries=$this->amenityQuery->search(str_slug($_GET['key']));
        $show_search='yes';
        return view('super-admin.amenity.query.index',compact('amenityQueries','show_search'));
    }
}
