@extends('layouts.super-admin.layouts')
@section('page-specific-css')
    <!-- Bootstrap Select Css -->
@stop
@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <!-- [ breadcrumb ] start -->
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">Place Your Order</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}">Dashboard</a></li>
                                        {{--<li class="breadcrumb-item"><a href="{{route('moq.index')}}">Order List</a></li>--}}
                                        <li class="breadcrumb-item"><a href="javascript:">Order Now</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form id="myForm" method="post" action="{{ route('order-list.store') }}" class="repeater" enctype="multipart/form-data"  data-parsley-validate novalidate autocomplete="off">
                        {!! csrf_field() !!}
                        <div class="main-body">
                            <div class="page-wrapper">
                                <!-- [ Main Content ] start -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <!-- [ form-element ] start -->
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5>Order With Us</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <input type="hidden" name="customer_id" value="{{ Auth::user()->id }}">
                                                            <div class="form-group orderrep">
                                                                <div class="col-md-12 m-t-10">
                                                                    <div data-repeater-list="arrayName" class="repeateList">
                                                                        <div data-repeater-item>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label for="status">Product <span class="text-danger">*</span></label>
                                                                                        <select class="form-control" id="productId" name="product_id" required onchange="productDetail(this.value)">
                                                                                            <option value="">Choose Product</option>
                                                                                            @foreach($products as $product)
                                                                                                <option value="{{$product->id}}">{{$product->title}}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                        <div id="moqDetails"></div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="form-group col-md-6">
                                                                                            <label>Quantity (case-wise) <span class="text-danger">*</span></label>
                                                                                            <input type="number" class="form-control" name="qty" id="qty" value="{{ old('qty') }}" placeholder="Enter Quantity"
                                                                                                   parsley-trigger="change" required onkeyup="getAmount()" >
                                                                                            <div id="moqErr" class="m-t-20"></div>
                                                                                        </div>
                                                                                        <span class="text-danger">{{ $errors->first('qty') }}</span>
                                                                                        <div class="form-group col-md-6">
                                                                                            <label>Amount {{$site_data->currency_format}} </label>
                                                                                            <input type="text" class="form-control" name="amount" id="amount"
                                                                                                   value="{{ old('amount') }}" placeholder="0" readonly>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="pull-right repeater-remove-btn">
                                                                                        <button data-repeater-delete type="button" class="btn btn-danger remove-btn">
                                                                                            Remove
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <hr size="50" noshade="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="repeater-heading">
                                                                    <button data-repeater-create type="button" class="btn btn-primary pt-2 pull-right repeater-add-btn m-l-15">
                                                                        <i class="fas fa-plus"></i> Add Your Order
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label for="remarks">Additional Info [If any]</label>
                                                                <textarea name="remarks" rows="6" class="form-control" placeholder="Enter info here."></textarea>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-12 m-t-20">
                                                            <div class="col-md-12">
                                                                <button type="submit" class="btn btn-success" id="btn-submit"><i class="fas fa-paper-plane"></i> Submit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-specific-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('form').parsley();
        });
        $('.orderrep').repeater({
            show: function () {
                $(this).slideDown();
            },
            hide: function (deleteElement) {
                if(confirm('Are you sure you want to delete this element?')) {
                }
                $(this).slideUp(deleteElement);
            },
            ready: function (setIndexes) {

            }
        });

    </script>
    <script>
        function productDetail(product_id) {
            var moqField = $(event.currentTarget).siblings().eq(1);
            var qty = $(event.currentTarget).parent().siblings().children().eq(0).children().eq(1).val('');
            var amnt = $(event.currentTarget).parent().siblings().children().eq(2).children().eq(1).val(0);
            var errorField =  $(event.currentTarget).parent().siblings().children().eq(0).children().eq(2).empty();

            $.ajax({
                async: false,
                method: 'GET',
                url: '{{ route('get-check-product') }}',
                data: {
                    product_id: product_id,
                },
                dataType: "json",
                success: function(response) {
                    moqField.empty().append(response.data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown)
                }
            });
        }
    </script>
    <script>
        var timer;
        function getAmount(){
            var qty = $(event.currentTarget).val();
            var amountField = $(event.currentTarget).parent().siblings().eq(1).children().eq(1);
            var errorField =  $(event.currentTarget).siblings().eq(1);
            errorField.empty();

            var productId = $(event.currentTarget).parent().parent().siblings().eq(0).children().eq(1).find(":selected").val();

            if (productId == '') {
                alert('Please choose product first!');
                event.preventDefault();
                $('#qty').val('');
            }
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
            errorMsg = '';

            timer && clearTimeout(timer);
            timer = setTimeout(function(){
                $.ajax({
                async: false,
                method: 'GET',
                url: '{{ route('checkMOQ') }}',
                data: {
                    productId: productId,
                    qty: qty,

                },

                success: function(response) {
//                    console.log(amountField);
                    if (response == 0) {
                        errorMsg += '<span class="text-danger"> Your order quantity should be in between MOQ.</span>';
                        errorField.empty();
                        errorField.append($.parseHTML(errorMsg));
                        $(window).keydown(function(event){
                            if(event.keyCode == 13) {
                                event.preventDefault();
                                return false;
                            }
                        });
                    } else {
                        errorField.empty();

                        amountField.val(response.amount);
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown)
                }
            });
            }, 500);


        }
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#myForm").submit(function (e) {
                $("#btn-submit").attr("disabled", true);
                return true;
            });
        });
    </script>
@endsection
