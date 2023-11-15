<div class="col-md-8">
    <div class="row">

        <div class="col-md-12">
            <div class="card user-list">
                <div class="card-header">
                    <h5>Product List</h5>
                </div>
                <div class="card-block pb-0">
                    <div class="table-responsive db-admin-view" id="orderMOQscroll">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th data-toggle="tooltip" data-placement="bottom" title="Minimum Order Quantity">MOQ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $k=>$product)
                                <tr id="{{$product->id}}">
                                    <td>{{$k+1}}</td>
                                    <td>
                                        <div class="image-trap">
                                            <a href="{{asset('uploads/Product/thumbnail/'.$product->image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class=" img-responsive">
                                                <img class="" style="width:70px;" src="{{asset('uploads/Product/thumbnail/'.$product->image)}}" alt="activity-user">
                                                <div class="g-title">
                                                    <i class="fa fa-search"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="mb-1">{{$product->title}}</h6>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" class="text text-info" data-toggle="modal" data-target="#moqDetail-{{$k}}" title="View Details"><i class="fa fa-info-circle"></i></a>
                                        <!-- moqDetail -->
                                        <div class="modal fade" id="moqDetail-{{$k}}" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="defaultModalLabel">Minimum Order Quantity</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            @if($product->moq->count()>0)
                                                                <table class="table">
                                                                    <thead><tr><th>{{$site_data->product_format}}</th><th>{{$site_data->product_type}}</th><th>Quantity</th><th>Rate {{$site_data->currency_format}}</th></tr></thead>
                                                                    <tbody>
                                                                    @foreach($product->moq as $details)
                                                                        <tr>
                                                                            <td>{{$details->batch_no}}</td>
                                                                            <td>{{$details->bottle_case}}</td>
                                                                            <td>{{$details->moq_low}} - {{$details->moq_high}}</td>
                                                                            <td>{{$details->rate}}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            @else
                                                                <h4 class="text-danger p-3">You have not set MOQ for this product.</h4>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Order History</h5>
                    <div style="float:right; margin:10px 0;">
                        <div class="btn-group card-option">
                            <a href="{{route('place-order')}}"><button type="button" class="btn btn-dark"><i class="fas fa-plus"></i> Place Order</button></a>
                        </div>
                    </div>
                </div>
                <div class="card-block">
                    <div class="table-responsive ">
                        <table id="scrolling-table" class="display table nowrap table-hover" style="width:100%">
                            <thead>
                            <tr>
                                <th>Order Information</th>
                                <th>Order Overview</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($allOrders as $orderList)
                                <?php
                                $total_orders = \App\Models\Model\SuperAdmin\OrderList\OrderList::where('order_no', $orderList->order_no)->where('is_cancelbycustomer', 'no')->get()->count();
                                $cancelled_items = \App\Models\Model\SuperAdmin\OrderList\OrderList::where('order_no', $orderList->order_no)->where('is_cancelbycustomer', 'no')->where('is_reject', 'yes')->get();
                                $approved_orders = $total_orders - count($cancelled_items);
                                ?>
                                <tr>
                                    <td>
                                        <h6 class="mb-1" style="font-weight: 800;">#{{$orderList->order_no}}</h6>
                                        <p>
                                            Order Placed On: {{date('d M, Y', strtotime($orderList->created_at))}}
                                            @if($orderList->estimate_delivery_date)
                                                <br>Estimate Delivery Date: {{date('d M, Y', strtotime($orderList->estimate_delivery_date))}}
                                            @endif
                                        </p>
                                    </td>
                                    <td>
                                        <h6>Total Purchased Order: {{$approved_orders}}</h6>
                                        @if($cancelled_items->count()>0)
                                            <h6>Total Cancelled Order: {{$cancelled_items->count()}}</h6>
                                        @endif
                                        {{--<h5 class="text-danger" >USD ${{number_format($orderList->net_amount)}}</h5>--}}
                                    </td>
                                    <td>
                                        @if($orderList->order_status == "is_request")
                                            <a href="{{route('view.place-order', $orderList->order_no)}}">
                                                <button type="button" class="btn btn-icon btn-rounded btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </a>

                                        @else
                                            <a href="{{route('order-full-details', $orderList->order_no)}}">
                                                <button type="button" class="btn btn-icon btn-rounded btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </a>
                                        @endif
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
<div class="col-md-4">
    <div class="col-md-12 text-center m-b-20">
        <h4>ORDER SUMMARY</h4>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-block border-bottom">
                <div class="row d-flex align-items-center">
                    <div class="col-auto">
                        <i class="fas fa-shopping-bag text-c-green f-36"></i>
                    </div>
                    <div class="col">
                        <h3 class="f-w-300">{{$allOrders->count()}}</h3>
                        <span class="d-block text-uppercase">TOTAL ORDERS</span>
                    </div>
                </div>
            </div>
            <div class="card-block border-bottom">
                <div class="row d-flex align-items-center">
                    <div class="col-auto">
                        <i class="fas fa-shopping-cart f-30 text-c-blue"></i>
                    </div>
                    <div class="col">
                        <h3 class="f-w-300">{{$cfmOrders->count()}}</h3>
                        <span class="d-block text-uppercase">CONFIRMED ORDERS</span>
                    </div>
                </div>
            </div>
            <div class="card-block">
                <div class="row d-flex align-items-center">
                    <div class="col-auto">
                        <i class="fas fa-times f-30 text-c-red"></i>
                    </div>
                    <div class="col">
                        <h3 class="f-w-300">{{$cancelledOrders}}</h3>
                        <span class="d-block text-uppercase">CANCELLED ORDERS</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 text-center" style="display: grid;">
            <a href="{{route('order-list.index')}}" class="btn btn-dark">VIEW ALL ORDER</a>
        </div>
    </div>

    @if(count($adminNotifications)>0)
        <div class="col-xl-12 col-md-12" style="margin-top:35px;">
            <div class="card note-bar">
                <div class="card-header">
                    <h5>Notifications</h5>
                </div>
                <div class="card-block p-0">
                    @foreach($adminNotifications as $notification)
                        <a href="javascript:void(0)" class="media friendlist-box">
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
</div>






