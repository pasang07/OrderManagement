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
                                        <li class="breadcrumb-item"><a href="{{route('order-list.index')}}">Order Details</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">#{{$order_number}}</a></li>
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
                                    <div class="card" id="contact_form">
                                        <div class="card-block">
                                            <div class="row invoive-info d-print-inline-flex">
                                                <div class="col-sm-4 invoice-client-info">
                                                    <h6>Customer Information :</h6>
                                                    <h6 class="m-0">{{$orderList->customer->name}}</h6>
                                                    <p class="m-0 m-t-10">{{$orderList->customer->address}}</p>
                                                    <p class="m-0">{{$orderList->customer->phone}}</p>
                                                    <p><a class="text-secondary" href="mailto:{{$orderList->customer->email}}" target="_top">{{$orderList->customer->email}}</a></p>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h6>Order Information :</h6>
                                                    <table class="table table-responsive invoice-table invoice-order table-borderless">
                                                        <tbody>
                                                        <tr>
                                                            <th>Ordered Date :</th>
                                                            <td>{{date('d M, Y', strtotime($orderList->created_at))}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Status :</th>
                                                            <td>
                                                                @if($orderList->order_status == "is_confirmed")
                                                                    <span class="label label-success">Confirmed</span>
                                                                @elseif($orderList->order_status == "is_review")
                                                                    <span class="label label-info">Not Confirm Yet</span>
                                                                @elseif($orderList->order_status == "is_request")
                                                                    <span class="label label-warning">Pending</span>
                                                                @else
                                                                    <span class="label label-danger">Cancelled</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h6 class="m-b-20">Order Number <span>#{{$order_number}}</span></h6>
                                                    <h6 class="m-b-20">
                                                        Total Purchased Items : {{$confirmedOrders}}
                                                    </h6>
                                                    <h6 class="text-uppercase text-danger" style="font-weight: 800;">Total Due :
                                                        <span>{{$site_data->currency_format}}{{number_format($totalOrdersAmount)}}</span>
                                                    </h6>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="table-responsive">
                                                        <table class="table  invoice-detail-table">
                                                            <thead>
                                                            <tr class="thead-default">
                                                                <th>S.N</th>
                                                                <th>Product Image</th>
                                                                <th>Product Name</th>
                                                                <th>Quantity</th>
                                                                <th>Total Amount {{$site_data->currency_format}}</th>
                                                                <th></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($totalOrders as $k=>$orderItem)
                                                            <tr id="{{$orderItem->id}}">
                                                                <td>{{$k + 1}}.</td>
                                                                <td>
                                                                    <div class="image-trap">
                                                                        <a href="{{asset('uploads/Product/thumbnail/'.$orderItem->product->image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class=" img-responsive">
                                                                            <img class="" style="width:70px;" src="{{asset('uploads/Product/thumbnail/'.$orderItem->product->image)}}" alt="No Image">
                                                                            <div class="g-title">
                                                                                <i class="fa fa-search"></i>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <p>{{$orderItem->product->title}}</p>
                                                                </td>
                                                                <td>{{$orderItem->qty}}</td>
                                                                <td>{{number_format($orderItem->amount)}}</td>
                                                                    <td>
                                                                        @if($orderList->order_status == "is_request" && $orderItem->is_cancelbycustomer == "no")
                                                                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#cancelIndvOrderModal-{{$k}}">Cancel</button>
                                                                            <!-- cancelIndvOrder -->
                                                                            <div class="modal fade" id="cancelIndvOrderModal-{{$k}}" tabindex="-1" role="dialog">
                                                                                <div class="modal-dialog" role="document">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h4 class="modal-title" id="defaultModalLabel">Attention !!!</h4>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            Are you sure you want to cancel <b>{{$orderItem->product->title}}</b>?
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <a href="{{route('individual-cancel.order', $orderItem->id)}}">
                                                                                                <button class="btn btn-danger">Yes, Cancel</button>
                                                                                            </a>
                                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        @if($orderItem->is_cancelbycustomer == "yes")
                                                                            <span class="text-danger" style="font-weight: 800; font-size:15px;">Cancelled</span>
                                                                        @endif
                                                                    </td>
                                                            </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($orderList->remarks)
                                                <div class="row m-t-10 m-b-10">
                                                    <div class="col-sm-12">
                                                        <h6>Additional Info:</h6>
                                                        <p>{{ $orderList->remarks }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="row">
                                                    <div class="col-sm-12">
                                                        <table class="table table-responsive invoice-table invoice-total">
                                                            <tbody>
                                                            <tr>
                                                                <th>Total Order :</th>
                                                                <td> {{$confirmedOrders}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Sub Total :</th>
                                                                <td>{{$site_data->currency_format}}{{number_format($totalOrdersAmount)}}</td>
                                                            </tr>
                                                            <tr class="text-info">
                                                                <td>
                                                                    <hr>
                                                                    <h5 class="text-primary m-r-10">Net Amount :</h5>
                                                                </td>
                                                                <td>
                                                                    <hr>
                                                                    <h5 class="text-primary m-r-10">{{$site_data->currency_format}}{{number_format($totalOrdersAmount)}}</h5>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--<div class="col-sm-12 invoice-btn-group text-center d-print-none">--}}
                                        {{--<button type="button" class="btn  btn-danger m-b-10 ">Cancel All Order</button>--}}
                                    {{--</div>--}}
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
@endsection
