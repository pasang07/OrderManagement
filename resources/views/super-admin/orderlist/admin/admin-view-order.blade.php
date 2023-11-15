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
                                        <li class="breadcrumb-item"><a href="{{route('order-query.index')}}">Order Details</a></li>
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
                                                <div class="col-sm-12 moq-admin-view m-b-10" id="orderMOQscroll">
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
                                                {{--<div class="col-sm-5 text-right">--}}
                                                    {{--<h4>Bank Details</h4>--}}
                                                    {{--{!! $site_data->bank_details !!}--}}
                                                {{--</div>--}}
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
                                                                @if($orderList->order_status == "is_request")
                                                                    <span class="label label-warning">Pending</span>
                                                                @elseif($orderList->order_status == "is_review")
                                                                    <span class="label label-info">Not Confirm Yet</span>
                                                                @elseif($orderList->order_status == "is_confirmed")
                                                                    <span class="label label-success">Confirmed</span>
                                                                @else
                                                                    <span class="label label-danger">Cancelled</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-sm-4">
                                                    <h6 class="m-b-20">Invoice Number <span>#{{$order_number}}</span></h6>
                                                    <h6 class="m-b-20">
                                                        Total Purchased Items : {{$totalOrders->count()}}
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
                                                                <th>Rate per bottle {{$site_data->currency_format}}</th>
                                                                <th>Total Amount {{$site_data->currency_format}}</th>
                                                                <th>Remarks</th>
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
                                                                           {{$moq->bottle_case}} {{$site_data->product_type}}
                                                                        </p>
                                                                    </td>
                                                                    <td>
                                                                        {{$orderItem->qty}}
                                                                        @if($orderItem->org_qty) <p class="text-danger" style="text-decoration: line-through;">{{$orderItem->org_qty}}</p> @endif
                                                                        @if($orderItem->org_qty)
                                                                        @else
                                                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#changeQty-{{$k}}" title="edit quantity"><i class="fa fa-edit text-primary"></i></a>
                                                                        <!-- cancelIndvOrder -->
                                                                        <div class="modal fade" id="changeQty-{{$k}}" tabindex="-1" role="dialog">
                                                                            <div class="modal-dialog" role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h4 class="modal-title" id="defaultModalLabel">Attention !!!</h4>
                                                                                    </div>
                                                                                    <form method="post" action="{{route('manage-OrderByAdmin',$orderItem->id)}}">
                                                                                        @csrf
                                                                                        <div class="modal-body">
                                                                                            <div class="row">
                                                                                                <input type="hidden" name="managed_by" value="{{Auth::user()->name}}" readonly>
                                                                                                <input type="hidden" name="product_id" value="{{$orderItem->product_id}}" readonly>
                                                                                                <div class="form-group col-md-12">
                                                                                                    <label>Quantity (case-wise) <span class="text-danger">*</span></label>
                                                                                                    <input type="text" class="form-control" name="managed_qty" value="{{ old('managed_qty')}}" placeholder="Enter Quantity" parsley-trigger="change" required>
                                                                                                </div>
                                                                                                <div class="form-group col-md-12">
                                                                                                    <label>Reason of edit<span class="text-danger">*</span></label>
                                                                                                    <textarea rows="5" class="form-control" name="managed_reason" placeholder="Enter Reason" parsley-trigger="change" required></textarea>
                                                                                                </div>

                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="submit" class="btn btn-info">Yes, Update</button>
                                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{$site_data->currency_format}}{{$moq->rate}}</td>
                                                                    <td>
                                                                        {{number_format($orderItem->amount)}}
                                                                        @if($orderItem->org_amount) <p class="text-danger" style="text-decoration: line-through;">{{number_format($orderItem->org_amount)}}</p> @endif
                                                                    </td>

                                                                    <td>
                                                                        @if($orderItem->org_qty && $orderItem->org_amount)
                                                                        @php
                                                                            $reason=wordwrap($orderItem->managed_reason,25,"<br />\n", false);
                                                                        @endphp
                                                                       Edit Reason:  @php echo "$reason"@endphp <br>
                                                                       Edited By: {{$orderItem->managed_by}}<br>
                                                                       Edited Date: {{date('d M, Y',strtotime($orderItem->managed_date))}}
                                                                       @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <form action="{{route('review.order.send',$orderList->order_no)}}" method="post" enctype="multipart/form-data"  data-parsley-validate novalidate autocomplete="off">
                                                {!! csrf_field() !!}
                                            <div class="row">
                                                    <div class="col-sm-12">
                                                        <input type="hidden" id="orgAmt" value="{{$totalOrdersAmount}}">
                                                        <table class="table table-responsive invoice-table invoice-total">
                                                            <tbody>
                                                            <tr>
                                                                <th>Sub Total :</th>
                                                                <td>{{$site_data->currency_format}}{{number_format($totalOrdersAmount)}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Discount &nbsp;<input type="number" min="0" class="myInput" name="discount_percent" id="discount_percent" onkeyup="discountByPercent()"><span>%</span>
                                                                    :</th>
                                                                <td>
                                                                    <span>{{$site_data->currency_format}}&nbsp;</span><input type="text" min="0" class="myInput1" name="discount_cost" id="discount_cost" onkeyup="discountByCost()" readonly>
                                                                </td>
                                                            </tr>
                                                            </tr>
                                                            <tr>
                                                                <th>VAT &nbsp;<input type="number" min="0" class="myInput" name="vat_percent" id="vat_percent" value="{{ old('vat_percent')}}" required onkeyup="vatCalculation()"  parsley-trigger="change" ><span>%</span>
                                                                    :</th>
                                                                <td>
                                                                    <span>{{$site_data->currency_format}}&nbsp;</span><input type="text" class="myInput1" name="vat_cost" id="vat_cost" value="{{ old('vat_cost')}}" readonly>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-danger">Shipping Cost *:</th>
                                                                <td>
                                                                    <span>{{$site_data->currency_format}}&nbsp;</span><input type="number" min="1" class="myInput1" name="shipping_cost" id="shipping_cost" value="{{ old('shipping_cost')}}" required onkeyup="calculateNetAmount()">
                                                                </td>
                                                            </tr>

                                                            <tr class="text-info">
                                                                <td>
                                                                    <hr>
                                                                    <h5 class="text-primary m-r-10">Net Amount :</h5>
                                                                </td>
                                                                <td>
                                                                    <hr>
                                                                    <span style="color: #2f85ff;">{{$site_data->currency_format}}</span><input type="text" class="myInput2" name="net_amount" id="net_amount" value="{{$totalOrdersAmount}}" readonly >
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                {{--<div class="col-sm-12">--}}
                                                    {{--<p class="text-info">Note: Net Amount will be calculated when shipping cost is typed.</p>--}}
                                                {{--</div>--}}
                                            </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group col-sm-3" style="float: right;">
                                                            <label>Estimated Delivery Date <span class="text-danger">*</span></label>
                                                            <input id="estimate_date" class="form-control" name="estimate_delivery_date">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 text-right">
                                                        <button type="submit" class="btn btn-success">Submit for confirmation</button>
                                                    </div>
                                                </div>
                                            </form>
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
        function discountByPercent(){
            var discountRate = $(event.currentTarget).val();
            var discountPercent =  parseFloat(discountRate) / 100;
            var org = $('#orgAmt').val();
            var orgAmt = parseFloat(org) * discountPercent;
            if(discountRate == '' || discountRate == 0){
                $('#discount_cost').val(0);
                var totalAmt = parseFloat(org);
                $('#net_amount').val(totalAmt.toFixed(2));
            }else{

                $('#discount_cost').val(orgAmt.toFixed(2));
                var totalAmt = parseFloat(org) - parseFloat(orgAmt);
                $('#net_amount').val(totalAmt.toFixed(2));
            }

        }
    </script>
    <script>
        function discountByCost(){
            var preDiscount = $('#orgAmt').val();
            var postDiscount = $(event.currentTarget).val();
            var discountAmt =  parseFloat(preDiscount) - parseFloat(postDiscount);
            var disAmt = parseFloat(discountAmt) / parseFloat(preDiscount);
            var disPercent = disAmt * 100;
            $('#discount_percent').val(disPercent.toFixed(2));
        }
    </script>
    <script>
        function vatCalculation(){
            var v = $(event.currentTarget).val();
            var discountedAmt = $('#discount_cost').val();
            var vatPercent =  parseFloat(v) / 100;
            var orgAmt = $('#orgAmt').val();
            if(v == ''){
                $('#vat_cost').val(0);
                var totalAmt = parseFloat(orgAmt) - parseFloat(discountedAmt);
                $('#net_amount').val(totalAmt.toFixed(2));
            }else {
                if(discountedAmt == '' || discountedAmt == 0){
                    var vatAmt = parseFloat(orgAmt) * parseFloat(vatPercent);
                    var vatIncludedAmt = parseFloat(orgAmt) + parseFloat(vatAmt);
                    $('#vat_cost').val(vatAmt.toFixed(2));
                    var totalAmt = parseFloat(orgAmt) + parseFloat(vatAmt);
                    $('#net_amount').val(totalAmt.toFixed(2));
                }else{
                    var vatAmtAfter = parseFloat(orgAmt) - parseFloat(discountedAmt);
                    var vatAmt = parseFloat(vatAmtAfter) * parseFloat(vatPercent);
                    $('#vat_cost').val(vatAmt.toFixed(2));
                    var totalAmt = parseFloat(orgAmt) + parseFloat(vatAmt) - parseFloat(discountedAmt);
                    $('#net_amount').val(totalAmt.toFixed(2));
                }
            }

        }
    </script>
<script>
    function calculateNetAmount(){
        var grossAmount = $('#orgAmt').val();
        var shippedCost = $(event.currentTarget).val();
        var distCost = $('#discount_cost').val();
        if(distCost == ''){
            distCost = 0;
        }else{
            distCost = distCost;
        }
        var vatIncluded = $('#vat_cost').val();
        if(vatIncluded == '' || isNaN(vatIncluded)){
            vatIncluded = 0;
        }else{
            vatIncluded = vatIncluded;
        }

        if(shippedCost == '' || shippedCost == 0){
            var totalAmt = parseFloat(grossAmount) + parseFloat(vatIncluded) - parseFloat(distCost);
            $('#net_amount').val(totalAmt.toFixed(2))
        }else{
            var totalAmt = parseFloat(grossAmount) + parseFloat(shippedCost) + parseFloat(vatIncluded) - parseFloat(distCost);
            $('#net_amount').val(totalAmt.toFixed(2))

        }

    }
</script>
@endsection
