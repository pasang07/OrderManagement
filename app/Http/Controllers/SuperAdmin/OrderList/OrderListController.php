<?php

namespace App\Http\Controllers\SuperAdmin\OrderList;

use App\Http\Controllers\ImageController;
use App\Http\Requests\SuperAdmin\OrderList\OrderListRequest;
use App\Models\Model\SuperAdmin\OrderList\OrderList;
use App\Models\Model\SuperAdmin\Product\Moq;
use App\Models\Model\SuperAdmin\Product\Product;
use App\Models\Model\SuperAdmin\SiteSetting\SiteSetting;
use App\Models\Model\SuperAdmin\User\User;
use App\Models\Service\SuperAdmin\OrderList\OrderListService;
use App\Notifications\Order\OrderReviewNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Kamaln7\Toastr\Facades\Toastr;
use App\Helpers\DbHelper as DbHelper;
use Illuminate\Support\Facades\Mail;

class OrderListController extends Controller
{
   protected $orderList;
    protected $imageController;
    function __construct(OrderListService $orderList)
    {
        $this->orderList=$orderList;
    }

    public function adminViewIndex()
    {
        $data['newOrders']=OrderList::where('is_confirm', 'no')->where('is_reviewed', 'no')->where('is_cancelbycustomer', 'no')->orderBy('order','desc')->get()->unique('order_no');
        $data['confirmOrders']=OrderList::where('is_confirm', 'yes')->where('is_reviewed', 'yes')->where('is_cancelled', 'no')->where('is_cancelbycustomer', 'no')->orderBy('order','desc')->get()->unique('order_no');
        return view('super-admin.orderlist.admin.admin-view-index',$data);
    }
    public function adminViewOrderDetails($orderNo)
    {
        $data['order_number'] = $orderNo;
        $data['orderedProducts'] = OrderList::where('order_no', $orderNo)->where('is_cancelbycustomer', 'no')->select('product_id')->orderBy('created_at', 'desc')->get()->unique('product_id');
        $data['orderList'] = OrderList::where('order_no', $orderNo)->where('is_cancelbycustomer', 'no')->orderBy('created_at', 'desc')->first();
        $data['totalOrders'] = OrderList::where('order_no', $orderNo)->where('is_cancelbycustomer', 'no')->orderBy('created_at', 'desc')->get();
        $data['totalOrdersAmount'] = OrderList::where('order_no', $orderNo)->where('is_cancelbycustomer', 'no')->orderBy('created_at', 'desc')->get()->sum('amount');

        return view('super-admin.orderlist.admin.admin-view-order',$data);
    }

    public function manageOrderByAdmin($orderId, Request $request){
        $orderDetail = OrderList::where('id', $orderId)->first();
        $org_qty = $orderDetail->qty;
        $org_amount = $orderDetail->amount;

        $managed_by = $request->get('managed_by');
        $managed_qty= $request->get('managed_qty');
        $managed_reason= $request->get('managed_reason');

        $moq = Moq::where('product_id', $request->get('product_id'))
            ->where('moq_low', '<=', $managed_qty)
            ->where('moq_high', '>=', $managed_qty)
            ->first();

        if($moq != null){
            $managed_amount = $managed_qty * $moq->rate * $moq->bottle_case ;

            DB::table('order_lists')->where('id', $orderId)->update([
                'org_qty' => $org_qty,
                'org_amount' => $org_amount,
                'qty' => $managed_qty,
                'amount' => $managed_amount,
                'managed_by' => $managed_by,
                'managed_reason' => $managed_reason,
                'managed_date' => Carbon::now()->format('Y-m-d'),
            ]);
            alert()->success('Order edit successfully', 'Success !!!')->persistent('Close');
            return redirect()->back();
        }else{
            alert()->error('Check MOQ for this product.', 'Oops !!!')->persistent('Close');
            return redirect()->back();
        }
    }

    public function reviewConfirmedByAdmin(Request $request, $orderNo)
    {
        DB::table('order_lists')->where('order_no', $orderNo)->update([
            'shipping_cost' => $request->shipping_cost,
            'discount_percent' => $request->discount_percent,
            'discount_cost' => $request->discount_cost,
            'vat_percent' => $request->vat_percent,
            'vat_cost' => $request->vat_cost,
            'net_amount' => $request->net_amount,
            'estimate_delivery_date' => $request->estimate_delivery_date,
            'is_reviewed' => 'yes',
            'order_status' => 'is_review',
        ]);
        $ord = OrderList::where('order_no', $orderNo)->first();
        $totalOrder = OrderList::where('order_no', $orderNo)->where('is_cancelbycustomer', 'no')->get()->count();
        $totalQty = OrderList::where('order_no', $orderNo)->where('is_cancelbycustomer', 'no')->get()->sum('qty');
        $grossAmount = OrderList::where('order_no', $orderNo)->where('is_cancelbycustomer', 'no')->get()->sum('amount');

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
            'order_no'=>'#'.$orderNo,
            'totalProduct'=>$totalOrder,
            'from'=>$ord->customer->email,
            'qty'=>$totalQty,
            'amount'=>$grossAmount,
            'customer_name'=>$ord->customer->name,
            'customer_phone'=>$ord->customer->phone,
            'customer_address'=>$ord->customer->address,
            'shipping_cost' => $request->shipping_cost,
            'discount_percent' => $request->discount_percent,
            'discount_cost' => $request->discount_cost,
            'vat_percent' => $request->vat_percent,
            'vat_cost' => $request->vat_cost,
            'net_amount' => $request->net_amount,
            'estimate_delivery_date' => $request->estimate_delivery_date,
            'email1'=>$email,
            'email2'=>$email2,
            'email3'=>$email3,
            'url' => SITE_URL

        );
        Mail::send('emails.order-review-mail',$data,function ($message) use ($data){
            $message->from(SITE_MAIL_EMAIL);
            $message->to($data['from']);
            $message->subject('Confirm Your Order - '.$data['order_no']);
        });
        $customerDetails = User::where('id', $ord->customer->id)->first();
        $customerDetails->notify(new OrderReviewNotification($customerDetails, $ord));

        alert()->success('Review sent successfully', 'Success !!!')->persistent('Close');
        return redirect()->route('order-query.index');
    }


    public function confirmedOrderPage($orderNo){
        $data['order_number'] = $orderNo;
        $data['orderList'] = OrderList::where('order_no', $orderNo)->where('is_cancelbycustomer', 'no')
            ->orderBy('created_at', 'desc')->first();
        $data['allOrders'] = OrderList::where('order_no', $orderNo)->where('is_cancelbycustomer', 'no')
            ->where('is_reviewed', 'yes')
            ->orderBy('created_at', 'desc')->get();
        $data['approveOrders'] = OrderList::where('order_no', $orderNo)->where('is_approve', 'yes')->where('is_confirm', 'yes')
            ->orderBy('created_at', 'desc')->get();
        $data['rejectOrders'] = OrderList::where('order_no', $orderNo)->where('is_reject', 'yes')->where('is_cancelled', 'yes')
            ->orderBy('created_at', 'desc')->get();
        $data['totalOrdersAmount'] = OrderList::where('order_no', $orderNo)->where('is_cancelbycustomer', 'no')->where('is_reject', 'no')
            ->orderBy('created_at', 'desc')
            ->get()->sum('amount');
        return view('super-admin.orderlist.admin.confirm-order-details',$data);
    }

}
