<?php

namespace App\Http\Controllers\SuperAdmin\ReferCustomer;

use App\Helpers\DbHelper;
use App\Http\Controllers\ImageController;
use App\Http\Requests\SuperAdmin\ReferCustomer\ReferCustomerRequest;
use App\Models\Model\SuperAdmin\ReferCustomer\ReferCustomer;
use App\Models\Model\SuperAdmin\SiteSetting\SiteSetting;
use App\Models\Model\SuperAdmin\User\User;
use App\Models\Service\SuperAdmin\ReferCustomer\ReferCustomerService;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminActionReferCustomerController extends Controller
{
   protected $referCustomer;
    protected $imageController;
    function __construct(ReferCustomerService $referCustomer, ImageController $imageController)
    {
        $this->referCustomer=$referCustomer;
        $this->imageController=$imageController;
    }

    public function index()
    {
        $data['allCustomers'] = User::where('refer_by', Auth::user()->id)->where('is_verified', 1)->orderBy('created_at','desc')->get();
        $data['referCustomers'] = ReferCustomer::where('is_approve', 'no')->orderBy('order','desc')->get();
        return view('super-admin.user.agent.refer-customer.admin.index',$data);
    }
    public function create()
    {
        return view('super-admin.user.agent.refer-customer.create');
    }

    public function store(ReferCustomerRequest $request)
    {
        if ($request->get('arrayName')) {
            $agentId = $request->get('agent_id');
            foreach (($request->get('arrayName')) as $customer) {
                $customerDetail = new ReferCustomer();
                $customerDetail->agent_id = $agentId;
                $customerDetail->name = $customer['name'];
                $customerDetail->email = $customer['email'];
                $customerDetail->phone = $customer['phone'];
                $customerDetail->address = $customer['address'];
                $customerDetail->order = DbHelper::nextSortOrder('refer_customers');
                $customerDetail->save();
            }
            $agent_detail = User::where('id', $request->get('agent_id'))->first();
            $site_data = SiteSetting::where('id', 1)->first();

            if($site_data->email == ''){
                $email = SITE_MAIL_EMAIL;
            }else{
                $email = $site_data->email;
            }
            if($site_data->email_2 == ''){
                $email2 = SITE_FIRST_MAIL_EMAIL;
            }else{
                $email2 = $site_data->email_2;
            }
            if($site_data->email_3 == ''){
                $email3 = SITE_SEC_MAIL_EMAIL;
            }else{
                $email3 = $site_data->email_3;
            }
            $data=array(
                'email1'=>$email,
                'email2'=>$email2,
                'email3'=>$email3,
                'agent_name'=>$agent_detail->name,
                'from'=>$agent_detail->email,
            );

//        Mail::send('emails.agent-user-request-mail',$data,function ($message) use ($data){
//            $message->from($data['from']);
//            $message->to($data['email1']);
//            $message->bcc([$data['email2'], $data['email3']]);
//            $message->subject('New Customer Request');
//        });

            alert()->success('Customer requested successfully.', 'Success !!!')->persistent('Close');
            return redirect()->route('refer-customer.index');
        }
    }
    public function edit($id)
    {
        $referCustomer=$this->referCustomer->find($id);
        return view('super-admin.user.agent.refer-customer.edit',compact('referCustomer'));
    }
    public function update(Request $request, $id)
    {
        $referCustomerInfo=$request->all();
        $referCustomer=$this->referCustomer->find($id);
        if($this->referCustomer->update($id, $referCustomerInfo)){

            alert()->success('Customer updated successfully.', 'Success !!!')->persistent('Close');
            return redirect()->route('refer-customer.index');
        }else{

            alert()->error('Unable to update customer.', 'Oops !!!')->persistent('Close');
            return redirect()->route('refer-customer.index');
        }
    }

    public function approve($id)
    {
        DB::table('refer_customers')->where('id', $id)->update([
            'is_approve' => 'yes',
            'approve_by' => Auth::user()->id,
            'approve_date' => Carbon::now()->format('Y-m-d')
        ]);

        $referCustomer=ReferCustomer::find($id);
        $password = Str::random(8);
        $code=sha1(time());

        $em= base64_encode($referCustomer->email);

        $customerEntry = new User();
        $customerEntry->name = $referCustomer->name;
        $customerEntry->phone = $referCustomer->phone;
        $customerEntry->address = $referCustomer->address;
        $customerEntry->email = $referCustomer->email;
        $customerEntry->password = bcrypt($password);
        $customerEntry->role = 'others';
        $customerEntry->status = 'active';
        $customerEntry->verification_code = $code;
        $customerEntry->refer_by = $referCustomer->agent_id;
        $customerEntry->created_at = Carbon::now();
        $customerEntry->updated_at = Carbon::now();

        if($customerEntry->save()){
            $data=array(
                'from'=>$referCustomer->email,
                'em'=>$em,
                'password'=>$password,
                'name'=>$referCustomer->name,
                'verification_code'=>$code,

            );
            Mail::send('emails.user-registration-mail',$data,function ($message) use ($data){
                $message->from(SITE_MAIL_EMAIL);
                $message->to($data['from']);
                $message->subject('Email Verification');
            });

            alert()->success('Customer approved successfully', 'Success !!!')->persistent('Close');
            return redirect()->route('admin-refer-customer.index');
        }else{
            alert()->error('Problem in approving customer.', 'Oops !!!')->persistent('Close');
            return redirect()->route('admin-refer-customer.index');
        }
    }
    public function reject($id)
    {
        $referCustomer=$this->referCustomer->find($id);
        if($this->referCustomer->delete($id)){
            $this->imageController->deleteImg('User',$referCustomer->image);

            alert()->success('Customer deleted successfully', 'Success !!!')->persistent('Close');
            return redirect()->route('refer-customer.index');
        }else{
            alert()->error('Problem in deleting customer.', 'Oops !!!')->persistent('Close');
            return redirect()->route('refer-customer.index');
        }
    }


}
