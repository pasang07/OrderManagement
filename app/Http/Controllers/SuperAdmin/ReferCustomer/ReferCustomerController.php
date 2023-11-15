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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ReferCustomerController extends Controller
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
        $data['allCustomers'] = User::where('refer_by', Auth::user()->id)->orderBy('created_at','desc')->get();
        $data['referCustomers'] = ReferCustomer::where('agent_id', Auth::user()->id)->orderBy('order','desc')->get();
        return view('super-admin.user.agent.refer-customer.index',$data);
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
                'url' => SITE_URL
            );
            Mail::send('emails.agent-user-request-mail',$data,function ($message) use ($data){
                $message->from($data['from']);
                $message->to($data['email1']);
                $message->bcc([$data['email2'], $data['email3']]);
                $message->subject('New Customer Request');
            });
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
    public function destroy($id)
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
