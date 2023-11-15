<?php

namespace App\Http\Controllers\SuperAdmin\Dashboard;

use App\Models\Model\SuperAdmin\AgentCommission\AgentCommission;
use App\Models\Model\SuperAdmin\Commission\Commission;
use App\Models\Model\SuperAdmin\OrderList\OrderList;
use App\Models\Model\SuperAdmin\Product\Product;
use App\Models\Model\SuperAdmin\ReferCustomer\ReferCustomer;
use App\Models\Model\SuperAdmin\User\User;
use App\Models\Service\SuperAdmin\Seo\SeoService;
use App\Models\Service\SuperAdmin\User\UserService;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class DashboardController extends Controller
{

    public function index()
    {
        //For admin
        $data['admins'] = User::where('created_by', Auth::user()->id)->where('role', 'admin')->where('status', 'active')->get()->count();
        $data['customers'] = User::where('created_by', Auth::user()->id)->where('role', 'others')->where('is_verified', 1)->where('status', 'active')->get()->count();
        $data['agents'] = User::where('created_by', Auth::user()->id)->where('role', 'agent')->where('is_verified', 1)->where('status', 'active')->get()->count();
        $data['requestedCustomer'] =  ReferCustomer::where('is_approve', 'no')->get()->count();
        $data['newOrders']=OrderList::where('is_confirm', 'no')->where('is_reviewed', 'no')->where('is_cancelbycustomer', 'no')->orderBy('order','desc')->get()->unique('order_no');
        $data['confirmOrders']=OrderList::where('is_confirm', 'yes')->where('is_reviewed', 'yes')->where('is_cancelled', 'no')->where('is_cancelbycustomer', 'no')->orderBy('order','desc')->get()->unique('order_no');
        $data['products'] = Product::where('status', 'active')->orderBy('order','desc')->get();
        $data['adminNotifications'] = User::find(Auth::user()->id)->notifications()->limit(5)->get();

        //For Customer
        $allOrders=OrderList::where('customer_id', Auth::user()->id)->where('is_cancelbycustomer', 'no')
            ->orderBy('order','desc')->take(10)->get()->unique('order_no');

        $cfmOrders=OrderList::where('customer_id', Auth::user()->id)
            ->where('is_confirm', 'yes')
            ->where('is_reviewed', 'yes')
            ->where('is_cancelled', 'no')
            ->where('is_cancelbycustomer', 'no')
            ->take(10)
            ->get()->unique('order_no');

        $cancelledOrders=OrderList::where('customer_id', Auth::user()->id)->where('is_reject', 'yes')->where('is_cancelled', 'yes')->where('is_cancelbycustomer', 'no')->get()->unique('order_no')->count();


        //For Agent Dashboard
        $m = Carbon::now()->format('m');
        $monthwiseCustomer = User::where('refer_by', Auth::user()->id)->where('is_verified', 1)
            ->whereMonth('created_at', $m)->orderBy('created_at', 'desc')->get();
        $agentBroughtCustomer = User::where('role', 'others')->where('refer_by', Auth::user()->id)->where('is_verified', 1)->orderBy('created_at', 'desc')->get();
        $inactiveCustomer = User::where('role', 'others')->where('refer_by', Auth::user()->id)->where('is_verified', 0)->orderBy('created_at', 'desc')->get();
        $approveCustomer = ReferCustomer::where('agent_id', Auth::user()->id)->where('is_approve', 'yes')->get();
        $referedCustomer = ReferCustomer::where('agent_id', Auth::user()->id)->where('is_approve', 'no')->get();
        $agentCommissions=AgentCommission::where('agent_id', Auth::user()->id)->orderBy('order','desc')->take(3)->get();
        $commissions =Commission::where('agent_id', Auth::user()->id)->orderBy('order','desc')->get()->sum('amount');

        return view('super-admin.dashboard.index',$data,compact('allOrders','cfmOrders','cancelledOrders', 'agentBroughtCustomer','monthwiseCustomer','inactiveCustomer',
            'approveCustomer','referedCustomer', 'agentCommissions','commissions'));
    }
}
