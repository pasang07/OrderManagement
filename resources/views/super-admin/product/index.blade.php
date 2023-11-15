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
                                        <li class="breadcrumb-item"><a href="javascript:">Product</a></li>
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
                                            <h5>Product List</h5>
                                        </div>
                                        <div class="button-card text-right ">
                                            <a href="{{route('product.create')}}"><button type="button" class="btn btn-dark"><i class="fas fa-plus"></i> Add Product</button></a>
                                            <div class="btn-group mb-2 mr-2">
                                                <button type="button" class="btn btn-danger">Action</button>
                                                <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="sr-only">Toggle Dropdown</span></button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" id="active" href="#!" data-id="product">Active</a>
                                                    <a class="dropdown-item" id="deactive" href="#!" data-id="product">Inactive</a>
                                                    <a class="dropdown-item" id="delete" href="#!" data-id="product">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table id="sortable" class="table table-hover todo-list ui-sortable">
                                                    <thead>
                                                        <tr>
                                                            <th><span class="handle"><i class="fas fa-arrows-alt"></i></span></th>
                                                            <th>S.N.</th>
                                                            <th>Title</th>
                                                            <th>MOQ</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                            <th><div class="custom-control custom-checkbox select-all">
                                                                    <input type="checkbox" id="checkAll" class="custom-control-input">
                                                                    <label class="custom-control-label" for="checkAll"></label>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $orders =''; $table='products'; ?>
                                                    @foreach($products as $k=>$product)
                                                        <?php $orders .= $product->order . ',';
                                                        ?>
                                                    <tr id="{{$product->id}}">
                                                        <td class="move">
                                                            <span class="handle">
                                                                <i class="fa fa-ellipsis-v"></i>
                                                                <i class="fa fa-ellipsis-v"></i>
                                                            </span>
                                                        </td>
                                                        <td>{{$k+1}}</td>
                                                        <td>
                                                            <h6 class="mb-1">{{$product->title}}</h6>
                                                        </td>
                                                        <!--<td>-->
                                                        <!--    <div class="image-trap">-->
                                                        <!--        <a href="{{asset('uploads/Product/thumbnail/'.$product->image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class=" img-responsive">-->
                                                        <!--            <img class="" style="width:70px;" src="{{asset('uploads/Product/thumbnail/'.$product->image)}}" alt="activity-user">-->
                                                        <!--            <div class="g-title">-->
                                                        <!--                <i class="fa fa-search"></i>-->
                                                        <!--            </div>-->
                                                        <!--        </a>-->
                                                        <!--    </div>-->
                                                        <!--</td>-->
                                                        <td>
                                                            <button type="button" class="btn btn-icon btn-outline-primary" data-toggle="modal" data-target="#moqDetail-{{$k}}"><i class="fas fa-info"></i></button>
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
                                                                                    <thead><tr><th>{{$site_data->product_format}}</th><th>{{$site_data->product_type}}</th><th>Quantity</th><th>Rate [{{$site_data->currency_format}}]</th></tr></thead>
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
                                                        <td>
                                                            @if($product->status=='active')
                                                                <button style="border: 0;cursor: pointer;" class="label theme-bg text-white f-12" value="{{$product->status}}" productId="{{$product->id}}" onclick="statusChange()">Active</button>
                                                            @else
                                                                <button style="border: 0;cursor: pointer;" class="label theme-bg2 text-white f-12" value="{{$product->status}}" productId="{{$product->id}}" onclick="statusChange()">Inactive</button>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{route('product.edit',$product->id)}}" ><button type="button" class="btn btn-icon btn-rounded btn-outline-primary"><i class="fas fa-edit"></i></button></a>
                                                            <button type="button" class="btn btn-icon btn-rounded btn-outline-danger" data-toggle="modal" data-target="#deleteModal-{{$k}}"><i class="fas fa-trash"></i></button>

                                                            <!-- delete -->
                                                            <div class="modal fade" id="deleteModal-{{$k}}" tabindex="-1" role="dialog">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title" id="defaultModalLabel">Attention !!!</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Are you sure you want to delete <b>{{$product->title}}</b>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <a href="{{route('product.destroy',$product->id)}}" class="btn btn-danger">Delete</a>
                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><div class="custom-control custom-checkbox select-1">
                                                                <input type="checkbox" class="custom-control-input" id="customCheck{{$k+1}}" name="id" value="{{$product->id}}">
                                                                <label class="custom-control-label" for="customCheck{{$k+1}}"></label>
                                                            </div></td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="justify-content-center">
                                                    <ul class="pagination">
                                                        {!! $products->render() !!}
                                                    </ul>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#sortable').tableDnD({
                onDrop: function (table, row) {
//            alert($.tableDnD.serialize());
                    $.ajax({method:'POST',url:'{{route('ajax.sortable')}}',data:{ids_order: $.tableDnD.serialize(), orders: '<?php echo $orders; ?>', table: '<?php echo $table; ?>', _token: '{!! csrf_token() !!}'}});
                }
            });
        });
    </script>
    <script>
        function statusChange() {
            var status = $(event.currentTarget).attr('value');
            var productId = $(event.currentTarget).attr('productId');
            data='';
            $.ajax({
                method: 'GET',
                url: '{{ route('change-status-button') }}',
                data: {
                    status : status,
                    productId: productId,
                },
                dataType: "json",
                success: function (response) {
                    if(response == 1){
                        swal({
                            title: "Success!",
                            text: "Product Status Changed!",
                            icon: "success",
                        });
                        location.reload();
                    }else{
                        swal({
                            title: "Oops!",
                            text: "Product Status Changed!",
                            icon: "error",
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown)
                }
            });
        }
    </script>
@endsection