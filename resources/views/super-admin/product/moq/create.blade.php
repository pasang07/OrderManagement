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
                                        <h5 class="m-b-10">Add Minimum Order Quantity</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}"><i class="feather icon-home"></i></a></li>
                                        <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('moq.index')}}">Minimum Order Quantity</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">Add MOQ</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="{{route('moq.store')}}" class="repeater" enctype="multipart/form-data"  data-parsley-validate novalidate autocomplete="off">
                        {!! csrf_field() !!}
                        @include('super-admin.product.moq.create-form')
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
        $('.rep').repeater({
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
        //getproductBatch list
        function getproductBatch() {
            var productId=$('#productId').val();
            data='';
            $.ajax({
                method: 'GET',
                url: '{{ route('get-productBatch') }}',
                data: {
                    productId: productId,
                },
                dataType: "json",
                success: function (response) {
                    data +='<div class="row">';
                    data += '<div class="col-md-6"><label for="productBatch">Batch</label><div class="input-group">';
                    data += '<input type="text" class="form-control" placeholder="Batch" aria-describedby="batchUnit" value="'+response.batch_no+'" readonly>';
                    data += '<div class="input-group-prepend"><span class="input-group-text" id="batchUnit">ml</span></div></div></div>';
                    data += '<div class="col-md-6"><div class="form-group"><label>No of bottles in case</label>';
                    data += '<input type="text" class="form-control" value="'+response.bottle_case+'" readonly></div></div>';
                    data +='</div>';
                    $('#batchInfo').empty();
                    $('#batchInfo').append($.parseHTML(data));
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown)
                }
            });
        }
        
        function calculateNow() {
            var rate = $(event.currentTarget).val();
//            console.log(rate);
            var moq = $(event.currentTarget).parent().parent().siblings().eq(1).children().children().eq(1).val();
//            console.log(moq);
            var amount = parseFloat(rate) * parseFloat(moq);
            $(event.currentTarget).parent().parent().siblings().eq(2).children().children().eq(1).val(amount);

        }
        </script>
@endsection
