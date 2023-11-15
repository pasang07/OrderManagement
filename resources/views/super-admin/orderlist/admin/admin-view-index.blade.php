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
                                                                            @if($orderList->customer->phone) {{$orderList->customer->phone}}<br> @endif
                                                                            @if($orderList->customer->email) {{$orderList->customer->email}}<br> @endif
                                                                            @if($orderList->customer->address){{$orderList->customer->address}}<br> @endif
                                                                        </p>
                                                                    </td>

                                                                    <td>
                                                                        <h6>Total Purchased Order: {{$ordered_items_list->count()}}</h6>
                                                                        {{--<p>--}}
                                                                            {{--Total Qty: {{$tot_qty}}<br>--}}
                                                                        {{--</p>--}}
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
                                                                        {{--<p>--}}
                                                                        {{--Total Qty: {{$tot_qty}}<br>--}}
                                                                        {{--</p>--}}
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
        function nwOrderSearch() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("nwOrder");
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
        function cfmOrderSearch() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("cfmOrder");
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
    </script>
@endsection

