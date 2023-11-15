<div class="col-md-12 col-xl-4">
    <div class="card card-social">
        <div class="card-block border-bottom">
            <div class="row align-items-center justify-content-center">
                <div class="col-auto">
                    <i class="fas fa-users text-info f-36"></i>
                </div>
                <div class="col text-right">
                    <h3>{{$customers}}</h3>
                    <h5 class="text-c-green mb-0"><span class="text-muted">Total Customers</span></h5>
                </div>
            </div>
        </div>
        <div class="card-block">
            <div class="row align-items-center justify-content-center card-active">
                <div class="col-6">
                    <h6 class="text-center m-b-10"><span class="text-muted m-r-5">Total Agents:</span>{{$agents}}</h6>
                    <div class="progress">
                        <div class="progress-bar progress-c-theme" role="progressbar" style="width:{{$agents}}%;height:6px;" aria-valuenow="{{$agents}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="col-6">
                    <h6 class="text-center  m-b-10"><span class="text-muted m-r-5">Total Admin:</span>{{$admins}}</h6>
                    <div class="progress">
                        <div class="progress-bar progress-c-theme2" role="progressbar" style="width:{{$admins}}%;height:6px;" aria-valuenow="{{$admins}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-xl-4">
    <div class="card yellow-theme-bg visitor">
        <div class="card-block text-center">
            <img class="img-female" src="{{asset('resources/super-admin/images/user/user-1.png')}}" alt="visitor-user">
            <h5 class="text-white m-0">REQUESTED CUSTOMERS</h5>
            <h3 class="text-white m-t-20 f-w-300">{{$requestedCustomer}}</h3>
            <span class="text-white">Referred by agent</span>
            <img class="img-men" src="{{asset('resources/super-admin/images/user/user-2.png')}}" alt="visitor-user">
        </div>
        <div class="card-footer text-center" style="border-top:none;padding:10px;">
            <a href="{{route('admin-refer-customer.index')}}"><h4 class="text-white">VIEW ALL</h4></a>
        </div>
    </div>
</div>

<div class="col-xl-4 col-md-12">
    <div class="card">
        <div class="card-block border-bottom">
            <div class="row d-flex align-items-center">
                <div class="col-auto">
                    <i class="fa fa-bullseye f-30 text-c-green"></i>
                </div>
                <div class="col">
                    <h3 class="f-w-300">{{$products->count()}}</h3>
                    <span class="d-block text-uppercase">TOTAL PRODUCT</span>
                </div>
            </div>
        </div>
        <div class="card-block">
            <div class="row d-flex align-items-center">
                <div class="col-auto">
                    <i class="fa fa-shopping-cart f-30 text-c-yel"></i>
                </div>
                <div class="col">
                    <h3 class="f-w-300">{{$confirmOrders->count()}}</h3>
                    <span class="d-block text-uppercase">CONFIRMED ORDERS</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="@if(count($adminNotifications)>0) col-xl-8 col-md-12 @else col-md-12 @endif">
    <div class="card">
        <div class="card-header">
            <h5>Order List</h5>
        </div>
        <div class="card-block">
            <ul class="nav nav-tabs" id="OrderTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active text-uppercase" id="newOrder-tab" data-toggle="tab" href="#newOrder" role="tab" aria-controls="newOrder" aria-selected="true">New Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase" id="cfrmOrder-tab" data-toggle="tab" href="#cfrmOrder" role="tab" aria-controls="cfrmOrder" aria-selected="false">Confirmed Orders</a>
                </li>
            </ul>
            <div class="tab-content" id="OrderTabContent" style="-webkit-box-shadow: none;box-shadow: none;">
                <div class="tab-pane fade show active" id="newOrder" role="tabpanel" aria-labelledby="newOrder-tab">
                    <div class="col-sm-4 float-right">
                        <input type="text" class="form-control" id="nwOrder" onkeyup="nwOrderSearch()" placeholder="Search By Order No.." style="margin-bottom: 10px;">
                    </div>
                    <div class="table-responsive">
                        <table id="sortable" class="table table-hover todo-list ui-sortable">
                            <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Order Number</th>
                                <th>Customer Details</th>
                                <th>Ordered Details</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($newOrders as $k=>$orderList)
                                <?php
                                $ordered_items_list = \App\Models\Model\SuperAdmin\OrderList\OrderList::where('order_no', $orderList->order_no)->where('is_cancelbycustomer', 'no')->get();
                                $tot_qty = \App\Models\Model\SuperAdmin\OrderList\OrderList::where('order_no', $orderList->order_no)->where('is_cancelbycustomer', 'no')->get()->sum('qty');
                                $tot_amt = \App\Models\Model\SuperAdmin\OrderList\OrderList::where('order_no', $orderList->order_no)->where('is_cancelbycustomer', 'no')->get()->sum('amount');
                                ?>
                                <tr id="{{$orderList->id}}">
                                    <td>{{$k+1}}</td>
                                    <td>
                                        <h6 class="mb-1">#{{$orderList->order_no}}</h6>
                                        <p>Order Placed On: {{date('d M, Y', strtotime($orderList->created_at))}}</p>
                                    </td>
                                    <td>
                                        <h6>{{$orderList->customer->name}}</h6>
                                        <p>
                                            {{$orderList->customer->phone}}<br>
                                            {{$orderList->customer->email}}<br>
                                            {{$orderList->customer->address}}<br>
                                        </p>
                                    </td>
                                    <td>
                                        <h6>Total Purchased Order: {{$ordered_items_list->count()}}</h6>
                                        {{--
                                        <p>--}}
                                        {{--Total Qty: {{$tot_qty}}<br>--}}
                                        {{--
                                     </p>
                                     --}}
                                        <h5 class="text-danger" >{{$site_data->currency_format}}{{number_format($tot_amt)}}</h5>
                                    </td>
                                    <td>
                                        <a href="{{route('order-view',$orderList->order_no)}}" ><button type="button" class="btn btn-icon btn-rounded btn-outline-primary"><i class="fas fa-eye"></i></button></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="cfrmOrder" role="tabpanel" aria-labelledby="cfrmOrder-tab">
                    <div class="col-sm-4 float-right">
                        <input type="text" class="form-control" id="cfmOrder" onkeyup="cfmOrderSearch()" placeholder="Search By Order No.." style="margin-bottom: 10px;">
                    </div>
                    <div class="table-responsive">
                        <table id="sortable1" class="table table-hover todo-list ui-sortable">
                            <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Order Number</th>
                                <th>Customer Details</th>
                                <th>Order Details</th>
                                <th>Estimate Delivery Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($confirmOrders as $k=>$orderList)
                                <?php
                                $ordered_items = \App\Models\Model\SuperAdmin\OrderList\OrderList::where('order_no', $orderList->order_no)->where('is_cancelbycustomer', 'no')->get();
                                $cancelled_orders = \App\Models\Model\SuperAdmin\OrderList\OrderList::where('order_no', $orderList->order_no)->where('is_cancelbycustomer', 'no')->where('is_reject', 'yes')->get();
                                $approved_orders = count($ordered_items) - count($cancelled_orders);
                                $tot_qty = \App\Models\Model\SuperAdmin\OrderList\OrderList::where('order_no', $orderList->order_no)->where('is_cancelbycustomer', 'no')->get()->sum('qty');
                                $amount = \App\Models\Model\SuperAdmin\OrderList\OrderList::where('order_no', $orderList->order_no)->where('is_cancelbycustomer', 'no')->get()->sum('amount');
                                ?>
                                <tr id="{{$orderList->id}}">
                                    <td>{{$k+1}}</td>
                                    <td>
                                        <h6 class="mb-1">#{{$orderList->order_no}}</h6>
                                        <p>Ordered Placed On:  {{date('d M, Y', strtotime($orderList->created_at))}}</p>
                                    </td>
                                    <td>
                                        <h6>{{$orderList->customer->name}}</h6>
                                        <p>
                                            @if($orderList->customer->phone)
                                                {{$orderList->customer->phone}}<br>
                                            @endif
                                            @if($orderList->customer->email)
                                                {{$orderList->customer->email}}<br>
                                            @endif
                                            @if($orderList->customer->address)
                                                {{$orderList->customer->address}}<br>
                                            @endif
                                        </p>
                                    </td>
                                    <td>
                                        <h6>Total Purchased Order: {{$approved_orders}}</h6>
                                        @if($cancelled_orders->count()>0)
                                            <h6>Total Cancelled Order: {{$cancelled_orders->count()}}</h6>
                                        @endif
                                        {{--
                                        <p>--}}
                                        {{--Total Qty: {{$tot_qty}}<br>--}}
                                        {{--
                                     </p>
                                     --}}
                                        @if($orderList->net_amount)
                                            <h5 class="text-danger" >{{$site_data->currency_format}}{{number_format($orderList->net_amount)}}</h5>
                                        @else
                                            <h5 class="text-danger" >{{$site_data->currency_format}}{{number_format($amount)}}</h5>
                                        @endif
                                    </td>
                                    <td>
                                        {{date('d M, Y', strtotime($orderList->estimate_delivery_date))}}
                                    </td>
                                    <td>
                                        <a href="{{route('confrim-order.details', $orderList->order_no)}}">
                                            <button type="button" class="btn btn-icon btn-rounded btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if(count($adminNotifications)>0)
<div class="col-xl-4 col-md-12">
    <div class="card note-bar">
        <div class="card-header">
            <h5>Notifications</h5>
        </div>
        <div class="card-block p-0">
            @foreach($adminNotifications as $notification)
                <a href="#!" class="media friendlist-box">
                    <div class="mr-3 photo-table">
                        <i class="far fa-bell f-30"></i>
                    </div>
                    <div class="media-body">
                        <h6>{{$notification->data['type']}}</h6>
                        <span class="f-12 float-right text-muted">{{date('d M, Y', strtotime($notification->created_at))}}</span>
                        <p class="text-muted m-0">{{$notification->data['text']}}</p>
                    </div>
                </a>

            @endforeach
        </div>
    </div>
</div>
@endif