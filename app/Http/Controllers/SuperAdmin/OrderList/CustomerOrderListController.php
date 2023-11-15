<?php

namespace App\Http\Controllers\SuperAdmin\OrderList;

use App\Http\Controllers\ImageController;
use App\Http\Requests\SuperAdmin\OrderList\OrderListRequest;
use App\Models\Model\SuperAdmin\Commission\Commission;
use App\Models\Model\SuperAdmin\OrderList\OrderList;
use App\Models\Model\SuperAdmin\OrderList\OrderListCancelbycustomer;
use App\Models\Model\SuperAdmin\Product\Moq;
use App\Models\Model\SuperAdmin\Product\Product;
use App\Models\Model\SuperAdmin\SiteSetting\SiteSetting;
use App\Models\Model\SuperAdmin\User\User;
use App\Models\Service\SuperAdmin\OrderList\OrderListService;
use App\Notifications\Order\OrderConfirmNotification;
use App\Notifications\Order\OrderConfirmWithAgentNotification;
use App\Notifications\Order\OrderPlaceNotification;
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

class CustomerOrderListController extends Controller
{
   protected $orderList;
    protected $imageController;
    function __construct(OrderListService $orderList)
    {
        $this->orderList=$orderList;
    }

    public function index()
    {
        $data['allOrders']=OrderList::where('customer_id', Auth::user()->id)->where('is_cancelbycustomer', 'no')->orderBy('order','desc')->get()->unique('order_no');
        $data['confirmOrders']=OrderList::where('customer_id', Auth::user()->id)->where('is_confirm', 'no')->where('is_reviewed', 'yes')->where('is_cancelled', 'no')->where('is_cancelbycustomer', 'no')->orderBy('order','desc')->get()->unique('order_no');
        $data['fixedOrders']=OrderList::where('customer_id', Auth::user()->id)->where('is_confirm', 'yes')->where('is_cancelbycustomer', 'no')->orderBy('order','desc')->get()->unique('order_no');
        $data['cancelledOrders']=OrderList::where('customer_id', Auth::user()->id)->where('is_cancelled', 'yes')->where('is_cancelbycustomer', 'no')->orderBy('order','desc')->get()->unique('order_no');
        return view('super-admin.orderlist.index',$data);
    }

    public function confirmOrderList()
    {
        $data['allOrders']=OrderList::where('customer_id', Auth::user()->id)->where('is_cancelbycustomer', 'no')->orderBy('order','desc')->get()->unique('order_no');
        $data['confirmOrders']=OrderList::where('customer_id', Auth::user()->id)->where('is_cancelbycustomer', 'no')->where('is_confirm', 'no')->where('is_reviewed', 'yes')->where('is_cancelled', 'no')->orderBy('order','desc')->get()->unique('order_no');
        $data['fixedOrders']=OrderList::where('customer_id', Auth::user()->id)->where('is_cancelbycustomer', 'no')->where('is_confirm', 'yes')->orderBy('order','desc')->get()->unique('order_no');
        $data['cancelledOrders']=OrderList::where('customer_id', Auth::user()->id)->where('is_cancelbycustomer', 'no')->where('is_cancelled', 'yes')->orderBy('order','desc')->get()->unique('order_no');
        return view('super-admin.orderlist.confirm-order',$data);
    }

    public function cancelOrderList()
    {
        $data['allOrders']=OrderList::where('customer_id', Auth::user()->id)->where('is_cancelbycustomer', 'no')->orderBy('order','desc')->get()->unique('order_no');
        $data['confirmOrders']=OrderList::where('customer_id', Auth::user()->id)->where('is_cancelbycustomer', 'no')->where('is_confirm', 'no')->where('is_reviewed', 'yes')->where('is_cancelled', 'no')->orderBy('order','desc')->get()->unique('order_no');
        $data['fixedOrders']=OrderList::where('customer_id', Auth::user()->id)->where('is_cancelbycustomer', 'no')->where('is_confirm', 'yes')->orderBy('order','desc')->get()->unique('order_no');
        $data['cancelledOrders']=OrderList::where('customer_id', Auth::user()->id)->where('is_cancelbycustomer', 'no')->where('is_cancelled', 'yes')->orderBy('order','desc')->get()->unique('order_no');
        return view('super-admin.orderlist.cancel-order',$data);
    }

    public function placeOrder()
    {
        $products = Product::where('status', 'active')->orderBy('title')->get();
        $customer = User::where('id', Auth::user()->id)->first();
        return view('super-admin.orderlist.place-order', compact('products', 'customer'));
    }

    public function checkedProductDetail(Request $request){

        $product_id = $request->get('product_id');

        $productDetail = Product::where('id', $product_id)
            ->with(array('moq' => function($query) {
                $query->orderBy('created_at')->get();
            }))
            ->first();

        $image =  asset('uploads/Product/thumbnail/'.$productDetail->image);

        if($productDetail != null){
            $data = '';
            $data .='<div class="row p-15">';
            if($productDetail->moq->count()>0){
                $data .='<div class="col-md-12 alert alert-info p-3" role="alert"><div class="row"><div class="col-md-3"><img src="'.$image.'" width="200"></div><div class="col-md-9"><h4 class="alert-heading text-center">'.$productDetail->title.' - Minimum Order Quantity [MOQ]</h4>';
                $data .='<div class="m-t-10">';
                $data .= '<table class="table">';
                $data .= '<thead><tr><th>Volume</th><th>Bottles</th><th>Quantity</th><th>Rate [USD $]</th></tr></thead>';
                $data .= '<tbody>';
                foreach($productDetail->moq as $m=>$moqs){
                    $data .='<tr>';
                    $data .='<td>'.$moqs->batch_no.' ML'.'</td>';
                    $data .='<td>'.$moqs->bottle_case.' Bottles'.'</td>';
                    $data .='<td>'.$moqs->moq_low.' - '.$moqs->moq_high.'</td>';
                    $data .='<td>'.$moqs->rate.'</td></tr>';
                }
                $data .= '</tbody></table></div>';

                $data .= '</div></div></div>';
            }
            $data .= '</div>';
            $response =[
                'product_id' => $product_id,
                'data' => $data,
            ];
            return response()->json($response);
        }
        else{
            return 0;
        }
    }

    public function checkMoq(Request $request){
        $qty = $request->get('qty');
        if($qty == ''){
            $qty = 0;
        }else{
            $qty = $request->get('qty');
        }
        $moq = Moq::where('product_id', $request->get('productId'))
            ->where('moq_low', '<=', $qty)
            ->where('moq_high', '>=', $qty)
            ->first();

//        dd($moq);
        if($moq != null){
            $amount = $qty * $moq->rate * $moq->bottle_case ;
            $response =[
                'amount' => $amount,

            ];
            return response()->json($response);
        }else{
            return 0;
        }
    }

    public function store(Request $request)
    {
        $today = date("Ymd");
        $rand = rand(0,9999);
        $on = $today.$rand;
        $customer_detail = User::where('id', $request->get('customer_id'))->first();
        $remarks = $request->get('remarks');

        if ($request->get('arrayName')) {
            foreach (($request->get('arrayName')) as $orderDet) {
                $pr = Product::where('id', $orderDet['product_id'])->first();
                $orderDetails['customer_id'] = $customer_detail->id;
                $orderDetails['product_id'] = $orderDet['product_id'];
                $orderDetails['order_no'] = $on;
                $orderDetails['qty'] = $orderDet['qty'];
                $orderDetails['amount'] = $orderDet['amount'];
                $orderDetails['remarks'] = $remarks;
                $orderDetails['order'] = DbHelper::nextSortOrder('order_lists');
                $this->orderList->create($orderDetails);
            }
            $latestOrder = OrderList::latest()->first();
            $orderAmount = OrderList::where('order_no', $latestOrder->order_no)->where('is_cancelbycustomer', 'no')->get()->sum('amount');
            $orderCount = OrderList::where('order_no', $latestOrder->order_no)->where('is_cancelbycustomer', 'no')->get()->count();
            $orderQty = OrderList::where('order_no', $latestOrder->order_no)->where('is_cancelbycustomer', 'no')->get()->sum('qty');

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
                'order_no'=>'#'.$latestOrder->order_no,
                'customer_name'=>$latestOrder->customer->name,
                'customer_phone'=>$latestOrder->customer->phone,
                'customer_address'=>$latestOrder->customer->address,
                'from'=>$latestOrder->customer->email,
                'remarks'=>$latestOrder->remarks,
                'gross_amount' => $orderAmount,
                'total_orders' => $orderCount,
                'qty'=>$orderQty,
                'email1'=>$email,
                'email2'=>$email2,
                'email3'=>$email3,
                'url' => SITE_URL
            );

            Mail::send('emails.order-registration-mail',$data,function ($message) use ($data){
                $message->from($data['from']);
                $message->to($data['email1']);
                $message->bcc([$data['email2'], $data['email3']]);
                $message->subject('New Order Request - '.$data['order_no']);
            });
            Mail::send('emails.order-registration-mail-reply',$data,function ($message) use ($data){
                $message->from(SITE_MAIL_EMAIL);
                $message->to($data['from']);
                $message->subject($data['order_no'].' - Order Request ' . SITE_TITLE);
            });

            $receivedUsers = User::where('role', 'admin')->where('status', 'active')->get();
            foreach($receivedUsers as $receivedUser){
                $sentUser = User::where('id', $request->get('customer_id'))->first();
                $receivedUser->notify(new OrderPlaceNotification($receivedUser, $sentUser));
            }
            alert()->success('Order placed successfully', 'Success !!!')->persistent('Close');
            return redirect()->route('order-list.index');
        }
    }

    public function viewPlacedOrder($orderNo){
        $data['order_number'] = $orderNo;
        $data['orderList'] = OrderList::where('order_no', $orderNo)->where('is_cancelbycustomer', 'no')->orderBy('created_at', 'desc')->first();
        $data['totalOrders'] = OrderList::where('order_no', $orderNo)->orderBy('created_at', 'desc')->get();
        $data['confirmedOrders'] = OrderList::where('order_no', $orderNo)->where('is_cancelbycustomer', 'no')->orderBy('created_at', 'desc')->get()->count();
        $data['totalOrdersAmount'] = OrderList::where('order_no', $orderNo)->where('is_cancelbycustomer', 'no')->where('is_reject', 'no')->orderBy('created_at', 'desc')->get()->sum('amount');
        return view('super-admin.orderlist.view-place-order',$data);
    }

    public function individualCancelOrderByCustomer($orderId){
        DB::table('order_lists')->where('id', $orderId)
            ->update([
                'is_cancelbycustomer' => 'yes'
            ]);
        $cancelledOrder = OrderList::where('id', $orderId)->where('is_cancelbycustomer', 'yes')->first();
        $allOrders = OrderList::where('order_no', $cancelledOrder->order_no)->get();
                $cancelledOrderDetail = new OrderListCancelbycustomer();
                $cancelledOrderDetail->customer_id = $cancelledOrder->customer_id;
                $cancelledOrderDetail->product_id = $cancelledOrder->product_id;
                $cancelledOrderDetail->order_no = $cancelledOrder->order_no;
                $cancelledOrderDetail->qty = $cancelledOrder->qty;
                $cancelledOrderDetail->amount = $cancelledOrder->amount;
                $cancelledOrderDetail->remarks = $cancelledOrder->remarks;
                $cancelledOrderDetail->shipping_cost = $cancelledOrder->shipping_cost;
                $cancelledOrderDetail->discount_percent = $cancelledOrder->discount_percent;
                $cancelledOrderDetail->discount_cost = $cancelledOrder->discount_cost;
                $cancelledOrderDetail->vat_percent = $cancelledOrder->vat_percent;
                $cancelledOrderDetail->vat_cost = $cancelledOrder->vat_cost;
                $cancelledOrderDetail->net_amount = $cancelledOrder->net_amount;
                $cancelledOrderDetail->estimate_delivery_date = $cancelledOrder->estimate_delivery_date;
                $cancelledOrderDetail->created_at = Carbon::now();
                $cancelledOrderDetail->updated_at = Carbon::now();
                $cancelledOrderDetail->save();

                OrderList::where('id', $orderId)->where('is_cancelbycustomer', 'yes')->delete();

                if(count($allOrders) > 0){
            alert()->success('Order cancelled successfully', 'Success !!!')->persistent('Close');
            return redirect()->back();
        }
        else{
            $site_data = SiteSetting::where('id', '1')->first();
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
                'order_no'=>'#'. $cancelledOrder->order_no,
                'customer_name'=> $cancelledOrder->customer->name,
                'customer_phone'=> $cancelledOrder->customer->phone,
                'customer_address'=> $cancelledOrder->customer->address,
                'from'=>$cancelledOrder->customer->email,
                'email1'=>$email,
                'email2'=>$email2,
                'email3'=>$email3,
                'url' => SITE_URL
            );

            Mail::send('emails.order-cancelbycustomer-mail',$data,function ($message) use ($data){
                $message->from($data['from']);
                $message->to($data['email1']);
                $message->bcc([$data['email2'], $data['email3']]);
                $message->subject('Order Cancelled - '.$data['order_no']);
            });

            alert()->success('Order cancelled successfully', 'Success !!!')->persistent('Close');
            return redirect()->route('order-list.index');
        }

    }

    public function viewOrderToConfirm($orderNo){

        $data['order_number'] = $orderNo;
        $data['orderedProducts'] = OrderList::where('order_no', $orderNo)->where('is_reviewed', 'yes')
            ->where('is_cancelbycustomer', 'no')->select('product_id')->orderBy('created_at', 'desc')->get()->unique('product_id');

        $data['orderList'] = OrderList::where('order_no', $orderNo)
            ->where('is_reviewed', 'yes')
            ->where('is_cancelbycustomer', 'no')
            ->orderBy('created_at', 'desc')->first();

        $data['totalOrders'] = OrderList::where('order_no', $orderNo)->where('is_reviewed', 'yes')
            ->where('is_cancelbycustomer', 'no')
            ->orderBy('created_at', 'desc')->get();

        $data['totalOrdersAmount'] = OrderList::where('order_no', $orderNo)->where('is_reviewed', 'yes')
            ->where('is_cancelled', 'no')->where('is_cancelbycustomer', 'no')
            ->where('is_reject', 'no')->orderBy('created_at', 'desc')->get()->sum('amount');

        $data['rejectedOrder'] = OrderList::where('order_no', $orderNo)
            ->where('is_reviewed', 'yes')
            ->where('is_cancelbycustomer', 'no')
            ->where('is_reject', 'yes')
            ->get()->count();


        return view('super-admin.orderlist.view-order-toConfirm', $data);
    }

    public function individualApproveOrderByCustomer($id){
        DB::table('order_lists')->where('id', $id)->update([
            'is_approve' => 'yes',
            'order_status' => 'is_approved',
        ]);
        alert()->success('Your Order Has Been Confirmed', 'Success !!!')->persistent('Close');
        return redirect()->back();
    }
    public function individualRejectOrderByCustomer(Request $request){
        $id = $request->get('orderId');
        $orderNo = OrderList::where('id', $id)->first()->order_no;
        $orderCount = OrderList::where('order_no', $orderNo)->where('is_reviewed', 'yes')
            ->where('is_cancelled', 'no')->where('is_cancelbycustomer', 'no')
            ->orderBy('created_at', 'desc')->get()->count();

        DB::table('order_lists')->where('id', $id)->update([
            'is_reject' => 'yes',
            'order_status' => 'is_reject',
        ]);
        $discountCost = 0;
        $vatCost = 0;

        //recalculating the price
        $orderGrossAmount = OrderList::where('order_no', $orderNo)->where('is_reviewed', 'yes')
            ->where('is_cancelled', 'no')->where('is_cancelbycustomer', 'no')
            ->where('is_reject', 'no')->orderBy('created_at', 'desc')->get()->sum('amount');

        $orderDetail = OrderList::where('order_no', $orderNo)->where('is_cancelbycustomer', 'no')
            ->where('is_cancelled', 'no')
            ->where('is_reviewed', 'yes')->first();

        if($orderDetail->discount_percent > 0){
            $discountPercent = $orderDetail->discount_percent / 100;
            $dst =  $orderGrossAmount * $discountPercent;
            $discountCost = number_format((float)$dst, 2, '.', '');

            $amountAfterDist = $orderGrossAmount - (float)($dst);
            if($orderDetail->vat_percent > 0){
                $vatPercent = $orderDetail->vat_percent / 100;
                $vt =  $amountAfterDist * $vatPercent;
                $vatCost = number_format((float)$vt, 2, '.', '');
            }
            $netTotal = $orderGrossAmount + $vatCost + $orderDetail->shipping_cost - $discountCost;
            $netAmount =number_format((float)$netTotal, 2, '.', '');

            DB::table('order_lists')->where('order_no', $orderNo)->update([
                'discount_cost' => $discountCost,
                'vat_cost' => $vatCost,
                'net_amount' => $netAmount,
            ]);
        }else{
            if($orderDetail->vat_percent > 0){
                $vatPercent = $orderDetail->vat_percent / 100;
                $vt =  $orderGrossAmount * $vatPercent;
                $vatCost = number_format((float)$vt, 2, '.', '');
            }
            $netTotal = $orderGrossAmount + $vatCost + $orderDetail->shipping_cost - $discountCost;
            $netAmount =number_format((float)$netTotal, 2, '.', '');

            DB::table('order_lists')->where('order_no', $orderNo)->update([
                'discount_cost' => $discountCost,
                'vat_cost' => $vatCost,
                'net_amount' => $netAmount,
            ]);
        }
        return 1;
    }

    public function sendOrderConfirmation($orderNo){
        $approvedOrder = OrderList::where('order_no', $orderNo)
            ->where('is_approve', 'yes')
            ->where('order_status', 'is_approved')
            ->get()->count();
        $approvedAmount = OrderList::where('order_no', $orderNo)
            ->where('is_approve', 'yes')
            ->where('order_status', 'is_approved')
            ->get()->sum('amount');
        $approvedQty = OrderList::where('order_no', $orderNo)
            ->where('is_approve', 'yes')
            ->where('order_status', 'is_approved')
            ->get()->sum('qty');
        $rejectOrder = OrderList::where('order_no', $orderNo)
            ->where('is_reject', 'yes')
            ->where('order_status', 'is_reject')
            ->get()->count();
        $rejectQty = OrderList::where('order_no', $orderNo)
            ->where('is_reject', 'yes')
            ->where('order_status', 'is_reject')
            ->get()->sum('qty');

        $site_data = SiteSetting::where('id', 1)->first();

        $orderDetails = OrderList::where('order_no', $orderNo)->first();

        $customerDetails = User::where('id', $orderDetails->customer_id)->first();

        if($customerDetails->refer_by == 'none'){
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
                'approveOrder'=>$approvedOrder,
                'rejectOrder'=>$rejectOrder,
                'approveQty'=>$approvedQty,
                'rejectQty'=>$rejectQty,
                'customer_name'=>$orderDetails->customer->name,
                'customer_phone'=>$orderDetails->customer->phone,
                'customer_address'=>$orderDetails->customer->address,
                'from'=>$orderDetails->customer->email,
                'amount'=>$approvedAmount,
                'shipping_cost' => $orderDetails->shipping_cost,
                'discount_percent' => $orderDetails->discount_percent,
                'discount_cost' => $orderDetails->discount_cost,
                'vat_percent' => $orderDetails->vat_percent,
                'vat_cost' => $orderDetails->vat_cost,
                'net_amount' => $orderDetails->net_amount,
                'estimate_delivery_date' => $orderDetails->estimate_delivery_date,
                'email1'=>$email,
                'email2'=>$email2,
                'email3'=>$email3,
                'url' => SITE_URL
            );

            Mail::send('emails.order-confirm-mail',$data,function ($message) use ($data){
                $message->from($data['from']);
                $message->to($data['email1']);
                $message->bcc([$data['email2'], $data['email3']]);
                $message->subject('Order Information - '.$data['order_no']);
            });
            Mail::send('emails.order-confirm-mail-reply',$data,function ($message) use ($data){
                $message->from(SITE_MAIL_EMAIL);
                $message->to($data['from']);
                $message->subject($data['order_no'].' - Order Information ' . SITE_TITLE);
            });

            $receivedUsers = User::where('role', 'admin')->where('status', 'active')->get();
            foreach($receivedUsers as $receivedUser){
                $receivedUser->notify(new OrderConfirmNotification($receivedUser, $customerDetails, $orderDetails));
            }

        }else{

            $agentDetails = User::where('id', $customerDetails->refer_by)->first();
            $finalOrders =  OrderList::where('order_no', $orderNo)->where('is_approve', 'yes')
                ->where('order_status', 'is_approved')->get();

            foreach($finalOrders as $finalOrder){
                //For bottle case
                $bottle = Moq::where('product_id', $finalOrder->product_id)
                    ->where('moq_low', '<=', $finalOrder->qty)
                    ->where('moq_high', '>=', $finalOrder->qty)
                    ->first()->bottle_case;

                $agentCommissions =  DB::table('agent_commissions')
                    ->where('status', 'active')
                    ->where('product_id', $finalOrder->product_id)
                    ->where('agent_id', $agentDetails->id)
                    ->pluck('price_per_bottle');

                foreach($agentCommissions as $price){
                    $qt = $finalOrder->qty;
                    $cm = (float)($qt * $bottle * $price);
                    $commissionDetails = new Commission();
                    $commissionDetails->agent_id = $agentDetails->id;
                    $commissionDetails->order_no = $orderNo;
                    $commissionDetails->customer_id = $finalOrder->customer_id;
                    $commissionDetails->product_id = $finalOrder->product_id;
                    $commissionDetails->qty = $qt;
                    $commissionDetails->amount = $cm;
                    $commissionDetails->received_date = Carbon::parse($finalOrder->updated_at)->format('Y-m-d');
                    $commissionDetails->order = DbHelper::nextSortOrder('commissions');
                    $commissionDetails->save();
                }

            }

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
                'approveOrder'=>$approvedOrder,
                'rejectOrder'=>$rejectOrder,
                'approveQty'=>$approvedQty,
                'rejectQty'=>$rejectQty,
                'customer_name'=>$orderDetails->customer->name,
                'customer_phone'=>$orderDetails->customer->phone,
                'customer_address'=>$orderDetails->customer->address,
                'from'=>$orderDetails->customer->email,
                'amount'=>$approvedAmount,
                'shipping_cost' => $orderDetails->shipping_cost,
                'discount_percent' => $orderDetails->discount_percent,
                'discount_cost' => $orderDetails->discount_cost,
                'vat_percent' => $orderDetails->vat_percent,
                'vat_cost' => $orderDetails->vat_cost,
                'net_amount' => $orderDetails->net_amount,
                'estimate_delivery_date' => $orderDetails->estimate_delivery_date,
                'email1'=>$email,
                'email2'=>$email2,
                'email3'=>$email3,
                'agentEmail'=>$agentDetails->email,
                'url' => SITE_URL
            );


            Mail::send('emails.order-confirm-mail',$data,function ($message) use ($data){
                $message->from($data['from']);
                $message->to($data['email1']);
                $message->bcc([$data['email2'], $data['email3']]);
                $message->subject('Order Confirmation - '.$data['order_no']);
            });
            Mail::send('emails.order-confirm-mail-reply',$data,function ($message) use ($data){
                $message->from(SITE_MAIL_EMAIL);
                $message->to($data['from']);
                $message->subject($data['order_no'].' - Order Confirmation');
            });
            Mail::send('emails.order-details-to-agent-mail',$data,function ($message) use ($data){
                $message->from($data['from']);
                $message->to($data['agentEmail']);
                $message->subject($data['order_no'].' - Order Confirmation');
            });


            $receivedUsers = User::where('role', 'admin')->where('status', 'active')->get();
            foreach($receivedUsers as $receivedUser){
                $receivedUser->notify(new OrderConfirmWithAgentNotification($receivedUser, $customerDetails, $agentDetails, $orderDetails));
                $agentDetails->notify(new OrderConfirmWithAgentNotification($receivedUser, $customerDetails, $agentDetails, $orderDetails));
            }
        }

        //action for approved order
        DB::table('order_lists')->where('order_no', $orderNo)->where('is_approve', 'yes')
            ->where('order_status', 'is_approved')->update([
                'is_confirm' => 'yes',
                'order_status' => 'is_confirmed',
            ]);

        //action for rejected order
        DB::table('order_lists')->where('order_no', $orderNo)->where('is_reject', 'yes')
            ->where('order_status', 'is_reject')->update([
                'is_cancelled' => 'yes',
                'order_status' => 'is_cancel',
            ]);

        alert()->success('Thank you for your confirmation', 'Success !!!')->persistent('Close');
        return redirect()->route('order-list.index');
    }

    public function allOrderReject($orderNo){

        $rejectedAmount = OrderList::where('order_no', $orderNo)
            ->where('is_reject', 'yes')
            ->where('order_status', 'is_reject')
            ->get()->sum('amount');
        $rejectOrder = OrderList::where('order_no', $orderNo)
            ->where('is_reject', 'yes')
            ->where('order_status', 'is_reject')
            ->get()->count();
        $rejectQty = OrderList::where('order_no', $orderNo)
            ->where('is_reject', 'yes')
            ->where('order_status', 'is_reject')
            ->get()->sum('qty');

        $site_data = SiteSetting::where('id', 1)->first();

        $orderDetails = OrderList::where('order_no', $orderNo)->first();

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
                'rejectOrder'=>$rejectOrder,
                'rejectQty'=>$rejectQty,
                'customer_name'=>$orderDetails->customer->name,
                'customer_phone'=>$orderDetails->customer->phone,
                'customer_address'=>$orderDetails->customer->address,
                'from'=>$orderDetails->customer->email,
                'amount'=>$rejectedAmount,
                'shipping_cost' => $orderDetails->shipping_cost,
                'discount_percent' => $orderDetails->discount_percent,
                'discount_cost' => $orderDetails->discount_cost,
                'vat_percent' => $orderDetails->vat_percent,
                'vat_cost' => $orderDetails->vat_cost,
                'net_amount' => $orderDetails->net_amount,
                'estimate_delivery_date' => $orderDetails->estimate_delivery_date,
                'email1'=>$email,
                'email2'=>$email2,
                'email3'=>$email3,
                'url' => SITE_URL
            );

            Mail::send('emails.order-cancel-mail',$data,function ($message) use ($data){
                $message->from($data['from']);
                $message->to($data['email1']);
                $message->bcc([$data['email2'], $data['email3']]);
                $message->subject('Order Information - '.$data['order_no']);
            });
            Mail::send('emails.order-cancel-mail-reply',$data,function ($message) use ($data){
                $message->from(SITE_MAIL_EMAIL);
                $message->to($data['from']);
                $message->subject($data['order_no'].' - Order Information ' . SITE_TITLE);
            });


        DB::table('order_lists')->where('order_no', $orderNo)->where('is_reject', 'yes')
            ->where('order_status', 'is_reject')->update([
                'is_cancelled' => 'yes',
                'reject_notification' => 'sent',
                'order_status' => 'is_cancel',
            ]);


        alert()->success('Your all order has been cancelled', 'Success !!!')->persistent('Close');
        return redirect()->route('order-list.index');
    }

    public function detailsAfterOrderConfirmation($orderNo){
        $data['order_number'] = $orderNo;
        $data['orderList'] = OrderList::where('order_no', $orderNo)->where('is_cancelbycustomer', 'no')
            ->orderBy('created_at', 'desc')->first();

        $data['orderedProducts'] = OrderList::where('order_no', $orderNo)->where('is_reviewed', 'yes')
            ->where('is_cancelbycustomer', 'no')->select('product_id')->orderBy('created_at', 'desc')->get()->unique('product_id');

        $data['allOrders'] = OrderList::where('order_no', $orderNo)->where('is_cancelbycustomer', 'no')
            ->where('is_reviewed', 'yes')
            ->orderBy('created_at', 'desc')->get();

        $data['approveOrders'] = OrderList::where('order_no', $orderNo)->where('is_approve', 'yes')
            ->orderBy('created_at', 'desc')->get();

        $data['rejectedOrder'] = OrderList::where('order_no', $orderNo)
            ->where('is_reject', 'yes')
            ->orderBy('created_at', 'desc')->get()->count();

        $data['totalOrdersAmount'] = OrderList::where('order_no', $orderNo)->where('is_cancelbycustomer', 'no')
            ->where('is_reviewed', 'yes')
            ->where('is_reject', 'no')
            ->where('is_cancelled', 'no')
            ->orderBy('created_at', 'desc')
            ->get()->sum('amount');

        $data['confirmedOrderCount'] = OrderList::where('order_no', $orderNo)->where('is_cancelbycustomer', 'no')
            ->where('is_approve', 'yes')->where('is_confirm', 'yes')
            ->where('is_reject', 'no')->where('is_cancelled', 'no')
            ->where('order_status', 'is_confirmed')
            ->get()->count();
        $data['rejectOrderCount'] = OrderList::where('order_no', $orderNo)->where('is_cancelbycustomer', 'no')
            ->where('is_approve', 'no')->where('is_confirm', 'no')
            ->where('is_reject', 'yes')->where('is_cancelled', 'yes')
            ->where('order_status', 'is_cancel')
            ->get()->count();


        return view('super-admin.orderlist.details-order',$data);
    }
    public function detailsRejectOrder($orderNo){
        $data['order_number'] = $orderNo;
        $data['orderList'] = OrderList::where('order_no', $orderNo)->where('is_cancelbycustomer', 'no')
            ->orderBy('created_at', 'desc')->first();

        $data['orderedProducts'] = OrderList::where('order_no', $orderNo)->where('is_reviewed', 'yes')
            ->where('is_cancelbycustomer', 'no')->select('product_id')->orderBy('created_at', 'desc')->get()->unique('product_id');

        $data['allOrders'] = OrderList::where('order_no', $orderNo)->where('is_cancelbycustomer', 'no')
            ->where('is_reviewed', 'yes')
            ->orderBy('created_at', 'desc')->get();

        $data['approveOrders'] = OrderList::where('order_no', $orderNo)->where('is_approve', 'yes')->where('is_confirm', 'yes')
            ->orderBy('created_at', 'desc')->get();

        $data['rejectedOrder'] = OrderList::where('order_no', $orderNo)
            ->where('is_reject', 'yes')
            ->orderBy('created_at', 'desc')->get()->count();

        $data['totalOrdersAmount'] = OrderList::where('order_no', $orderNo)->where('is_cancelbycustomer', 'no')
            ->where('is_reviewed', 'yes')
            ->where('is_reject', 'no')
            ->where('is_cancelled', 'no')
            ->orderBy('created_at', 'desc')
            ->get()->sum('amount');

        $data['confirmedOrderCount'] = OrderList::where('order_no', $orderNo)->where('is_cancelbycustomer', 'no')
            ->where('is_approve', 'yes')->where('is_confirm', 'yes')
            ->where('is_reject', 'no')->where('is_cancelled', 'no')
            ->where('order_status', 'is_confirmed')
            ->get()->count();
        $data['rejectOrderCount'] = OrderList::where('order_no', $orderNo)->where('is_cancelbycustomer', 'no')
            ->where('is_approve', 'no')->where('is_confirm', 'no')
            ->where('is_reject', 'yes')->where('is_cancelled', 'yes')
            ->where('order_status', 'is_cancel')
            ->get()->count();


        return view('super-admin.orderlist.full-order-details',$data);
    }
}
