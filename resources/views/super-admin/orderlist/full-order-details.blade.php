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
                                                    <h6 class="m-b-20" style="font-weight: 800;">Order Number <span>#{{$order_number}}</span></h6>
                                                    <h6 class="m-b-20">Ordered Date:
                                                        {{date('d M, Y', strtotime($orderList->created_at))}}
                                                    </h6>
                                                    <h6 class="m-b-20">Estimate Date of delivery:
                                                        {{date('d M, Y', strtotime($orderList->estimate_delivery_date))}}
                                                    </h6>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h6 class="m-b-20">
                                                        Total Confirmed Items : {{$approveOrders->count()}}
                                                    </h6>
                                                    <h6 class="m-b-20">
                                                        Total Cancelled Items : {{$rejectedOrder}}
                                                    </h6>
                                                    {{--<h6 class="text-uppercase text-danger" style="font-weight: 800;">Total Payment :--}}
                                                        {{--<span>${{number_format($orderList->net_amount)}}</span>--}}
                                                    {{--</h6>--}}
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
                                                                <th>Rate {{$site_data->currency_format}}  <br> per bottle</th>
                                                                <th>Total Amount <br> {{$site_data->currency_format}}</th>
                                                                <th>Remarks</th>
                                                                <th>Status</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($allOrders as $k=>$orderItem)
                                                                <?php
                                                                $moq = \App\Models\Model\SuperAdmin\Product\Moq::where('product_id', $orderItem->product_id)
                                                                    ->where('moq_low', '<=', $orderItem->qty)
                                                                    ->where('moq_high', '>=', $orderItem->qty)
                                                                    ->first();
                                                                ?>
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
                                                                        <p>
                                                                            {{$orderItem->product->title}}
                                                                            <br>
                                                                           {{$moq->bottle_case}} {{$site_data->product_type}}
                                                                        </p>
                                                                    </td>
                                                                    <td>
                                                                        {{$orderItem->qty}}
                                                                        @if($orderItem->org_qty) <p class="text-danger" style="text-decoration: line-through;">{{$orderItem->org_qty}}</p> @endif
                                                                    </td>
                                                                    <td>{{$moq->rate}}</td>
                                                                    <td>
                                                                        {{number_format($orderItem->amount)}}
                                                                        @if($orderItem->org_amount) <p class="text-danger" style="text-decoration: line-through;">{{$site_data->currency_format}}{{number_format($orderItem->org_amount)}}</p> @endif
                                                                    </td>

                                                                    <td>
                                                                        @if($orderItem->org_qty && $orderItem->org_amount)
                                                                            @php
                                                                                $reason=wordwrap($orderItem->managed_reason,20,"<br />\n", false);
                                                                            @endphp
                                                                            Edit Reason:  @php echo "$reason"@endphp <br>
                                                                            Edited By: {{$orderItem->managed_by}}<br>
                                                                            Edited Date: {{date('d M, Y',strtotime($orderItem->managed_date))}}
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if($orderItem->is_confirm == "yes")
                                                                            <i class="fa fa-check-circle text-success"></i>
                                                                        @else
                                                                            <i class="fa fa-times-circle text-danger"> </i>
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
                                                <div class="row  m-t-20 m-b-20">
                                                    <div class="col-sm-12">
                                                        <h6>Additional Info:</h6>
                                                        <p>{{ $orderList->remarks }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif

                                            @if($site_data->bank_details)
                                                <div class="row  m-t-20 m-b-20">
                                                    <div class="col-sm-12">
                                                        <h6>Bank Details:</h6>
                                                        {!! $site_data->bank_details !!}
                                                    </div>
                                                </div>
                                            @endif

                                            @if($totalOrdersAmount > 0)
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <table class="table table-responsive invoice-table invoice-total">
                                                        <tbody>
                                                        <tr>
                                                            <th>Sub Total :</th>
                                                            <td> {{$site_data->currency_format}}{{number_format($totalOrdersAmount)}}</td>
                                                        </tr>
                                                        @if($orderList->discount_percent > 0)
                                                            <tr>
                                                                <th>Discount ({{$orderList->discount_percent}}%):</th>
                                                                <td>
                                                                    {{$site_data->currency_format}}{{$orderList->discount_cost}}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @if($orderList->vat_percent > 0)
                                                            <tr>
                                                                <th>VAT ({{$orderList->vat_percent}}%):</th>
                                                                <td>
                                                                    {{$site_data->currency_format}}{{$orderList->vat_cost}}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        <tr>
                                                            <th>Shipping Cost:</th>
                                                            <td>
                                                                {{$site_data->currency_format}}{{$orderList->shipping_cost}}
                                                            </td>
                                                        </tr>

                                                        <tr class="text-info">
                                                            <td>
                                                                <hr>
                                                                <h5 class="text-primary m-r-10">Net Amount :</h5>
                                                            </td>
                                                            <td>
                                                                <hr>
                                                                <h5 class="text-primary m-r-10"> {{$site_data->currency_format}}{{number_format($orderList->net_amount)}}</h5>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            @endif


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
