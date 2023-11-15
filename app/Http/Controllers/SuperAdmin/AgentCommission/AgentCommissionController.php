<?php

namespace App\Http\Controllers\SuperAdmin\AgentCommission;

use App\Http\Controllers\ImageController;
use App\Http\Requests\SuperAdmin\AgentCommission\AgentCommissionRequest;
use App\Models\Model\SuperAdmin\AgentCommission\AgentCommission;
use App\Models\Model\SuperAdmin\Product\Product;
use App\Models\Model\SuperAdmin\User\User;
use App\Models\Service\SuperAdmin\AgentCommission\AgentCommissionService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Kamaln7\Toastr\Facades\Toastr;
use App\Helpers\DbHelper as DbHelper;
class AgentCommissionController extends Controller
{
   protected $agentCommission;
    protected $imageController;
    function __construct(AgentCommissionService $agentCommission, ImageController $imageController)
    {
        $this->agentCommission=$agentCommission;
        $this->imageController=$imageController;
    }

    public function index()
    {
        $agentLists = User::where('role', 'agent')->where('status', 'active')->orderBy('created_at', 'desc')->paginate(50);
        return view('super-admin.user.agent.commission.index',compact('agentLists'));
    }

    public function manage($id)
    {
        $agent = User::where('id', $id)->first();
        $agentCommissions=AgentCommission::where('agent_id', $id)->get();
        $products = Product::where('status', 'active')->orderBy('created_at', 'desc')->get();
        return view('super-admin.user.agent.commission.manage-index',compact('agent','agentCommissions', 'products', 'id'));
    }

    public function viewCommission($id)
    {
        $agentCommissions=AgentCommission::where('agent_id', $id)->where('status', 'active')->get();
        return view('super-admin.user.agent.commission.agent-commission-index',compact('agentCommissions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'=>'required',
            'price_per_bottle'=>'required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }
        $agentId = $request->get('agent_id');

        if(AgentCommission::where('agent_id', $agentId)->where('product_id', '=', $request->get('product_id'))->exists())
        {
            alert()->error('Unable to set commission of the same product.', 'Sorry !!!')->persistent('Close');
            return redirect()->route('manage-commission.index', $agentId);
        }
        else{
            $agentCommissionInfo = $request->all();
            $agentCommissionInfo['agent_id'] = $agentId;
            $agentCommissionInfo['order'] =  DbHelper::nextSortOrder('agent_commissions');
            if($this->agentCommission->create($agentCommissionInfo)){
                alert()->success('Commission set successfully', 'Success !!!')->persistent('Close');
                return redirect()->route('manage-commission.index', $agentId);
            }else{
                alert()->error('Problem in creating commission', 'Oops !!!')->persistent('Close');
                return redirect()->route('manage-commission.index', $agentId);
            }
        }
    }

    public function update(Request $request, $id)
    {
        $agentCommissionInfo=$request->all();
        $agentCommission=$this->agentCommission->find($id);
        if($this->agentCommission->update($id, $agentCommissionInfo)){
            alert()->success('Commission updated successfully', 'Success !!!')->persistent('Close');
            return redirect()->route('manage-commission.index', $agentCommission->agent_id);
        }else{
            alert()->error('Problem in updating Commission', 'Oops !!!')->persistent('Close');
            return redirect()->route('manage-commission.index', $agentCommission->agent_id);
        }
    }
    public function destroy($id)
    {
        $agentCommission=$this->agentCommission->find($id);
        if($this->agentCommission->delete($id)){
            $this->imageController->deleteImg('AgentCommission',$agentCommission->image);
            Toastr::success('Commission deleted successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('agentCommission.index');
        }else{
            Toastr::error('Problem in deleting agentCommission', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('agentCommission.index');
        }
    }
    public function changeCommissionStatus(Request $request)
    {
        $status = $request->get('status');
        $commissionId = $request->get('commissionId');

        if($status == 'active'){

            DB::table('agent_commissions')->where('id', $commissionId)->update([
                'status' => 'in_active'
            ]);
        }else{

            DB::table('agent_commissions')->where('id', $commissionId)->update([
                'status' => 'active'
            ]);
        }

        return 1;
    }

}
