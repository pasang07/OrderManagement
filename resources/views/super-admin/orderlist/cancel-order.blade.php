@extends('layouts.super-admin.layouts')
@section('content')
    <section class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <!-- [ breadcrumb ] start -->
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10"></h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">Order List</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ breadcrumb ] end -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <!-- [ configuration table ] start -->
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Order List</h5>
                                            <div class="text-right">
                                                <a href="{{route('place-order')}}"><button type="button" class="btn btn-dark"><i class="fas fa-plus"></i> Place Order</button></a>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <ul class="nav nav-tabs" id="OrderTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link text-uppercase" id="allorder-tab" data-toggle="tab" href="#allorder" role="tab" aria-controls="allorder" aria-selected="true">All Orders</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link text-uppercase" id="cfrmOrder-tab" data-toggle="tab" href="#cfrmOrder" role="tab" aria-controls="cfrmOrder" aria-selected="false">Order to be confirmed</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link text-uppercase" id="fixedOrder-tab" data-toggle="tab" href="#fixedOrder" role="tab" aria-controls="fixedOrder" aria-selected="false">Confirmed Order</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link active text-uppercase" id="cancelledOrder-tab" data-toggle="tab" href="#cancelledOrder" role="tab" aria-controls="cancelledOrder" aria-selected="false">Cancelled Order</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="OrderTabContent" style="-webkit-box-shadow: none;box-shadow: none;">
                                                <div class="tab-pane fade" id="allorder" role="tabpanel" aria-labelledby="allorder-tab">
                                                    {{--<div class="col-sm-4 float-right">--}}
                                                    {{--<input type="text" class="form-control" id="allOrder" onkeyup="allOrderSearch()" placeholder="Search By Order No.." style="margin-bottom: 10px;">--}}
                                                    {{--</div>--}}
                                                    <div class="table-responsive">
                                                        <table id="col-reorder1" class="table table-hover todo-list ui-sortable">
                                                            <thead>
                                                            <tr>
                                                                <th>S.N.</th>
                                                                <th>Order Number</th>
                                                                <th>Ordered Details</th>
                                                                <th>Ordered Status</th>
                                                                <th>View Details</th>
                                                            </tr>
                                                            </thead>

                                                            <tbody>
                                                            @foreach($allOrders as $k=>$orderList)
                                                                <?php
                                                                $total_orders = \App\Models\Model\SuperAdmin\OrderList\OrderList::where('order_no', $orderList->order_no)->where('is_cancelbycustomer', 'no')->get()->count();
                                                                $cancelled_items = \App\Models\Model\SuperAdmin\OrderList\OrderList::where('order_no', $orderList->order_no)->where('is_cancelbycustomer', 'no')->where('is_reject', 'yes')->get();
                                                                $approved_orders = $total_orders - count($cancelled_items);
                                                                $tot_amt = \App\Models\Model\SuperAdmin\OrderList\OrderList::where('order_no', $orderList->order_no)->where('is_cancelbycustomer', 'no')->get()->sum('amount');
                                                                ?>
                                                                <tr id="{{$orderList->id}}">
                                                                    <td>{{$k+1}}</td>
                                                                    <td>
                                                                        <h6 class="mb-1" style="font-weight: 800;">#{{$orderList->order_no}}</h6>
                                                                        Order Placed On: {{date('d M, Y', strtotime($orderList->created_at))}}
                                                                        @if($orderList->estimate_delivery_date)
                                                                            <br>Estimate Delivery Date: {{date('d M, Y', strtotime($orderList->estimate_delivery_date))}}
                                                                        @endif
                                                                    </td>

                                                                    <td>
                                                                        <h6>Total Purchased Order: {{$approved_orders}}</h6>
                                                                        @if($cancelled_items->count()>0)
                                                                            <h6>Total Cancelled Order: {{$cancelled_items->count()}}</h6>
                                                                        @endif
                                                                        @if($orderList->net_amount)
                                                                            <h5 class="text-danger" >{{$site_data->currency_format}}{{number_format($orderList->net_amount)}}</h5>
                                                                        @else
                                                                            <h5 class="text-danger" >{{$site_data->currency_format}}{{number_format($tot_amt)}}</h5>
                                                                        @endif

                                                                    </td>
                                                                    <td>
                                                                        @if($orderList->order_status == "is_request")
                                                                            <span class="label label-warning">Pending</span>
                                                                        @elseif($orderList->order_status == "is_review")
                                                                            <span class="label label-info">Not Confirm Yet</span>
                                                                        @elseif($orderList->order_status == "is_confirmed")
                                                                            <span class="label label-success">Confirmed</span>
                                                                        @elseif($orderList->order_status == "is_cancel")
                                                                            <span class="label label-danger">Cancelled</span>
                                                                        @else
                                                                            <span class="label label-danger">Approval Waiting</span>
                                                                        @endif
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
                                                <div class="tab-pane fade" id="cfrmOrder" role="tabpanel" aria-labelledby="cfrmOrder-tab">
                                                    {{--<div class="col-sm-4 float-right">--}}
                                                    {{--<input type="text" class="form-control" id="confrmOrder" onkeyup="confrmOrderSearch()" placeholder="Search By Order No.." style="margin-bottom: 10px;">--}}
                                                    {{--</div>--}}
                                                    <div class="table-responsive">
                                                        <table id="col-reorder2" class="table table-hover todo-list ui-sortable">
                                                            <thead>
                                                            <tr>
                                                                <th>S.N.</th>
                                                                <th>Order Number</th>
                                                                <th>Order Details</th>
                                                                <th>Date</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($confirmOrders as $k=>$orderList)
                                                                <?php
                                                                $ordered_items = \App\Models\Model\SuperAdmin\OrderList\OrderList::where('order_no', $orderList->order_no)->where('is_cancelbycustomer', 'no')->get();
                                                                $tot_amt = \App\Models\Model\SuperAdmin\OrderList\OrderList::where('order_no', $orderList->order_no)->where('is_cancelbycustomer', 'no')->get()->sum('amount');
                                                                ?>
                                                                <tr id="{{$orderList->id}}">
                                                                    <td>{{$k+1}}</td>
                                                                    <td>
                                                                        <h6 class="mb-1">#{{$orderList->order_no}}</h6>
                                                                    </td>
                                                                    <td>
                                                                        <h6>Total Purchased Order: {{$ordered_items->count()}}</h6>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                Gross Amount: <br>
                                                                                @if($orderList->discount_cost)
                                                                                    Discount ({{$orderList->discount_percent}}%): <br>
                                                                                @endif
                                                                                @if($orderList->vat_cost)
                                                                                    VAT ({{$orderList->vat_percent}}%): <br>
                                                                                @endif
                                                                                @if($orderList->shipping_cost)
                                                                                    Shipping Cost: <br>
                                                                                @endif
                                                                                <hr>
                                                                                <h5 class="text-danger"> Total Amount:</h5>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                {{$site_data->currency_format}}{{number_format($tot_amt)}} <br>
                                                                                @if($orderList->discount_cost)
                                                                                    {{$site_data->currency_format}}{{number_format($orderList->discount_cost)}} <br>
                                                                                @endif
                                                                                @if($orderList->vat_cost)
                                                                                    {{$site_data->currency_format}}{{number_format($orderList->vat_cost)}} <br>
                                                                                @endif
                                                                                @if($orderList->shipping_cost)
                                                                                    {{$site_data->currency_format}}{{number_format($orderList->shipping_cost)}} <br>
                                                                                @endif
                                                                                <hr>
                                                                                <h5 class="text-danger"> {{$site_data->currency_format}}{{number_format($orderList->net_amount)}} </h5>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <p>Ordered Placed On:  {{date('d M, Y', strtotime($orderList->created_at))}}</p>
                                                                        <p>Estimate Delivery Date: {{date('d M, Y', strtotime($orderList->estimate_delivery_date))}}</p>

                                                                    </td>
                                                                    <td>
                                                                        <a href="{{route('order-full-details', $orderList->order_no)}}">
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

                                                <div class="tab-pane fade" id="fixedOrder" role="tabpanel" aria-labelledby="fixedOrder-tab">
                                                    <div class="table-responsive">
                                                        <table id="col-reorder"  class="table table-hover todo-list ui-sortable">
                                                            <thead>
                                                            <tr>
                                                                <th>S.N.</th>
                                                                <th>Order Number</th>
                                                                <th>Order Details</th>
                                                                <th>View Details</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($fixedOrders as $k=>$orderList)
                                                                <?php
                                                                $total_orders = \App\Models\Model\SuperAdmin\OrderList\OrderList::where('order_no', $orderList->order_no)->where('is_cancelbycustomer', 'no')->get()->count();
                                                                $cancelled_items = \App\Models\Model\SuperAdmin\OrderList\OrderList::where('order_no', $orderList->order_no)->where('is_cancelbycustomer', 'no')->where('is_reject', 'yes')->get();
                                                                $approved_orders = $total_orders - count($cancelled_items);
                                                                $tot_amt = \App\Models\Model\SuperAdmin\OrderList\OrderList::where('order_no', $orderList->order_no)->where('is_cancelbycustomer', 'no')->get()->sum('amount');
                                                                ?>
                                                                <tr id="{{$orderList->id}}">
                                                                    <td>{{$k+1}}</td>
                                                                    <td>
                                                                        <h6 class="mb-1">#{{$orderList->order_no}}</h6>
                                                                        <p>Ordered Placed On:  {{date('d M, Y', strtotime($orderList->created_at))}}<br>
                                                                            Delivered On:  {{date('d M, Y', strtotime($orderList->estimate_delivery_date))}}</p>
                                                                    </td>

                                                                    <td>
                                                                        <h6>Total Purchased Order: {{$approved_orders}}</h6>
                                                                        <h5 class="text-danger" >{{$site_data->currency_format}}{{number_format($orderList->net_amount)}}</h5>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{route('order-full-details', $orderList->order_no)}}">
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

                                                <div class="tab-pane fade show active" id="cancelledOrder" role="tabpanel" aria-labelledby="cancelledOrder-tab">
                                                    <div class="col-sm-4 float-right">
                                                        <input type="text" class="form-control" id="cncOrder" onkeyup="cncOrderSearch()" placeholder="Search By Order No.." style="margin-bottom: 10px;">
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table id="sortable3" class="table table-hover todo-list ui-sortable">
                                                            <thead>
                                                            <tr>
                                                                <th>S.N.</th>
                                                                <th>Order Number</th>
                                                                <th>Order Details</th>
                                                                <th>View Details</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($cancelledOrders as $k=>$orderList)
                                                                <?php
                                                                $total_orders = \App\Models\Model\SuperAdmin\OrderList\OrderList::where('order_no', $orderList->order_no)->where('is_cancelbycustomer', 'no')->get()->count();
                                                                $cancelled_items = \App\Models\Model\SuperAdmin\OrderList\OrderList::where('order_no', $orderList->order_no)->where('is_cancelbycustomer', 'no')->where('is_reject', 'yes')->get();
                                                                $approved_orders = $total_orders - count($cancelled_items);
                                                                $tot_amt = \App\Models\Model\SuperAdmin\OrderList\OrderList::where('order_no', $orderList->order_no)->where('is_cancelbycustomer', 'no')->get()->sum('amount');
                                                                ?>
                                                                <tr id="{{$orderList->id}}">
                                                                    <td>{{$k+1}}</td>
                                                                    <td>
                                                                        <h6 class="mb-1">#{{$orderList->order_no}}</h6>
                                                                        <p>
                                                                            Ordered Placed On:  {{date('d M, Y', strtotime($orderList->created_at))}}<br>
                                                                            Delivered On:  {{date('d M, Y', strtotime($orderList->estimate_delivery_date))}}
                                                                        </p>
                                                                    </td>

                                                                    <td>
                                                                        <h6>Total Cancelled Order: {{$cancelled_items->count()}}</h6>
                                                                        @if($approved_orders > 0)
                                                                            <h6>Total Purchased Order: {{$approved_orders}}</h6>
                                                                        @endif
                                                                        <h5 class="text-danger" >{{$site_data->currency_format}}{{number_format($orderList->net_amount)}}</h5>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{route('order-full-details', $orderList->order_no)}}">
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
                                <!-- [ configuration table ] end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('page-specific-scripts')
    <script>
        function allOrderSearch() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("allOrder");
            filter = input.value.toUpperCase();
            table = document.getElementById("sortable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
        function confrmOrderSearch() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("confrmOrder");
            filter = input.value.toUpperCase();
            table = document.getElementById("sortable1");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        function fixeOrderSearch() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("fixeOrder");
            filter = input.value.toUpperCase();
            table = document.getElementById("sortable2");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
        function cncOrderSearch() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("cncOrder");
            filter = input.value.toUpperCase();
            table = document.getElementById("sortable3");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
@endsection
