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
                                        <li class="breadcrumb-item"><a href="{{route('order-list.index')}}">Order List</a></li>
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
                                    <div class="card">
                                        <div class="card-block">
                                            <div class="row m-b-10">
                                                <div class="col-sm-8 moq-admin-view m-b-10" id="orderMOQscroll">
                                                    @foreach($orderedProducts as $pr=>$product)
                                                        <div class="table-responsive">
                                                            <h5 style="margin-bottom:30px;">{{$product->product->title}} - Minimum Order Quantity</h5>
                                                            <table class="table invoice-detail-table">
                                                                <thead>
                                                                <tr><th>{{$site_data->product_format}}</th><th>{{$site_data->product_type}}</th><th>Quantity</th><th>Rate</th></tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($product->product->moq as $details)
                                                                    <tr>
                                                                        <td>{{$details->batch_no}}</td>
                                                                        <td>{{$details->bottle_case}}</td>
                                                                        <td>{{$details->moq_low}} - {{$details->moq_high}}</td>
                                                                        <td>{{$site_data->currency_format}}{{$details->rate}}</td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="text-right">
                                                        <h4>Bank Details</h4>
                                                        {!! $site_data->bank_details !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row invoive-info m-t-30">
                                                <div class="col-sm-4 invoice-client-info">
                                                    <h6>Customer Information :</h6>
                                                    <h6 class="m-0">{{$orderList->customer->name}}</h6>
                                                    <p class="m-0 m-t-10">{{$orderList->customer->address}}</p>
                                                    <p class="m-0">{{$orderList->customer->phone}}</p>
                                                    <p><a class="text-secondary" href="mailto:{{$orderList->customer->email}}" target="_top">{{$orderList->customer->email}}</a></p>
                                                </div>

                                                <div class="col-sm-4">
                                                    <h6 class="m-b-20" >Order Number <span style="font-weight: 800;">#{{$order_number}}</span></h6>
                                                    <h6 class="m-b-20" >Ordered Date: {{date('d M, Y', strtotime($orderList->created_at))}}</h6>
                                                    @if($orderList->estimate_delivery_date)
                                                    <h6 class="m-b-20" >Estimate Delivery Date: {{date('d M, Y', strtotime($orderList->estimate_delivery_date))}}</h6>
                                                    @endif
                                                </div>
                                                <div class="col-sm-4">
                                                    <h6 class="m-b-20">Total Purchased Items : {{$totalOrders->count()}}</h6>
                                                    @if($rejectedOrder > 0)
                                                        <h6 class="m-b-20">Total Rejected Items : {{$rejectedOrder}}</h6>
                                                    @endif
                                                    <h6 class="text-uppercase text-danger" style="font-weight: 800;">Total Due :
                                                        <span>${{number_format($orderList->net_amount)}}</span>
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
                                                                <th>Quantity <br> [in cases]</th>
                                                                <th>Rate  <br> per bottle</th>
                                                                <th>Total Amount <br> [USD $]</th>
                                                                <th>Remarks</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($totalOrders as $k=>$orderItem)
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
                                                                            No of bottles in a case:  {{$moq->bottle_case}}
                                                                        </p>
                                                                    </td>
                                                                    <td>
                                                                        {{$orderItem->qty}}
                                                                        @if($orderItem->org_qty) <p class="text-danger" style="text-decoration: line-through;">{{$orderItem->org_qty}}</p> @endif
                                                                    </td>
                                                                    <td>${{$moq->rate}}</td>
                                                                    <td>
                                                                        $ {{number_format($orderItem->amount)}}
                                                                        @if($orderItem->org_amount) <p class="text-danger" style="text-decoration: line-through;">$ {{number_format($orderItem->org_amount)}}</p> @endif
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
                                                                        @if($orderItem->is_approve == "yes" && $orderItem->is_reject == "no")
                                                                            <h6 class="badge badge-info">
                                                                                Approved
                                                                            </h6>
                                                                        @elseif($orderItem->is_approve == "no" && $orderItem->is_reject == "yes")
                                                                            <h6 class="badge badge-danger"> Rejected</h6>
                                                                        @else
                                                                        <a href="{{route('individual-approve.order', $orderItem->id)}}" class="btn btn-info">Approve</a>
                                                                        <button class="btn btn-danger" orderId = "{{$orderItem->id}}" onclick="rejectOrder()">Reject</button>
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
                                            @if($totalOrders->count() == $rejectedOrder)
                                                <div class="row">
                                                    <div class="col-sm-12 text-right">
                                                        <a href="{{route('order-list.index')}}" class="btn btn-warning">Send Your Confirmation</a>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <table class="table table-responsive invoice-table invoice-total">
                                                            <tbody>
                                                            <tr>
                                                                <th>Sub Total :</th>
                                                                <td> ${{number_format($totalOrdersAmount)}}</td>
                                                            </tr>
                                                            @if($orderList->discount_percent > 0)
                                                                <tr>
                                                                    <th>Discount ({{$orderList->discount_percent}}%):</th>
                                                                    <td>
                                                                        ${{$orderList->discount_cost}}
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            @if($orderList->vat_percent > 0)
                                                                <tr>
                                                                    <th>VAT ({{$orderList->vat_percent}}%):</th>
                                                                    <td>
                                                                        ${{$orderList->vat_cost}}
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <th>Shipping Cost:</th>
                                                                <td>
                                                                    ${{$orderList->shipping_cost}}
                                                                </td>
                                                            </tr>

                                                            <tr class="text-info">
                                                                <td>
                                                                    <hr>
                                                                    <h5 class="text-primary m-r-10">Net Amount :</h5>
                                                                </td>
                                                                <td>
                                                                    <hr>
                                                                    <h5 class="text-primary m-r-10"> ${{number_format($orderList->net_amount)}}</h5>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 text-right">
                                                        <a href="{{route('send-order.confirmation', $orderList->order_no)}}" class="btn btn-success">Send Your Confirmation</a>
                                                    </div>
                                                </div>
                                            @endif
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
    function rejectOrder(){
        var orderId = $(event.currentTarget).attr('orderId');
        $.ajax({
            method: 'GET',
            url: '{{ route('individual-reject.order') }}',
            data: {
                orderId: orderId,
            },
            dataType: "json",
            success: function (response) {

                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown)
            }
        });
    }
</script>
@endsection
