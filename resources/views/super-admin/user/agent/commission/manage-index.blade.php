@extends('layouts.super-admin.layouts')
@section('content')
    <?php $remaining = count($products) - count($agentCommissions); ?>
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
                                        <li class="breadcrumb-item"><a href="javascript:">{{$agent->name}}</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">Manage Commission</a></li>
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
                                <div class="col-sm-6" @if($remaining == 0) style="display: none;" @endif>
                                        <form id="myForm" method="post" action="{{ route('agent-commission.store') }}" class="repeater" enctype="multipart/form-data"  data-parsley-validate novalidate autocomplete="off">
                                        {!! csrf_field() !!}
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5>Set Commission</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <input type="hidden" name="agent_id" value="{{ $agent->id }}">
                                                            <div class="row">
                                                                <div class="form-group col-md-5">
                                                                    <label for="status">Product <span class="text-danger">*</span></label>
                                                                    <select class="form-control" name="product_id" required>
                                                                        <option value="">Choose Product</option>
                                                                        @foreach($products as $product)
                                                                            <option value="{{$product->id}}">{{$product->title}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-5">
                                                                    <label>Commission Per Bottle $ <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="price_per_bottle" value="{{ old('price_per_bottle') }}" placeholder="Enter Price" parsley-trigger="change" required>
                                                                </div>
                                                                <span class="text-danger">{{ $errors->first('price_per_bottle') }}</span>
                                                                <div class="col-md-2">
                                                                    <div class="m-t-25">
                                                                        <button type="submit" class="btn btn-icon btn-success"><i class="fas fa-save"></i> </button>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        {{--<div class="col-md-12 m-t-20">--}}
                                                            {{--<div class="col-md-12">--}}
                                                                {{--<button type="submit" class="btn btn-success" id="btn-submit"><i class="fas fa-paper-plane"></i> Submit</button>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </form>
                                </div>

                                <div class="@if($remaining > 0) col-sm-6  @else col-md-12 @endif">

                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-3">Commissions</h5>
                                            <div class="text-right">
                                                <input action="action" onclick="window.history.go(-1); return false;" type="submit" value="<< Go Back"/>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <div class="m-b-20">
                                                <div class="table-responsive m-t-20">
                                                    <table class="table m-b-0 f-14 b-solid requid-table">
                                                        <thead>
                                                        <tr class="text-uppercase">
                                                            <th>#</th>
                                                            <th>Product</th>
                                                            <th>Commission</th>
                                                            <th>Edit</th>
                                                            <th>Status</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="text-muted">
                                                        @foreach($agentCommissions as $k=>$commission)
                                                            <?php
                                                            $product_name = \App\Models\Model\SuperAdmin\Product\Product::where('id', $commission->product_id)->first()->title;
                                                            ?>
                                                        <tr>
                                                            <td>{{$k + 1}}</td>
                                                            <td>{{$commission->product->title}}</td>
                                                            <td> ${{$commission->price_per_bottle}} per bottle</td>
                                                            <td>
                                                                <button type="button" class="btn btn-icon btn-rounded btn-outline-info" data-toggle="modal" data-target="#editMod-{{$k}}"><i class="fas fa-edit"></i></button>

                                                                <!-- delete -->
                                                                <div class="modal fade" id="editMod-{{$k}}" tabindex="-1" role="dialog">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="defaultModalLabel">Update !!!</h4>
                                                                            </div>
                                                                            <form method="post" action="{{route('agent-commission.update', $commission->id)}}" autocomplete="off">
                                                                                @csrf
                                                                            <div class="modal-body">
                                                                                <div class="form-group">
                                                                                    <label>Product</label>
                                                                                    <input type="text" class="form-control" value="{{$product_name}}" readonly>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Commission Per Bottle $ <span class="text-danger">*</span></label>
                                                                                    <input type="text" class="form-control" name="price_per_bottle" value="{{ old('price_per_bottle', isset($commission->price_per_bottle) ? $commission->price_per_bottle: '')}}" placeholder="Enter Price" parsley-trigger="change" required>
                                                                                </div>
                                                                                <span class="text-danger">{{ $errors->first('price_per_bottle') }}</span>
                                                                                <div class="form-group">
                                                                                    <label for="status">Status</label>
                                                                                    <select class="form-control" id="status" name="status" >
                                                                                        <option value="active" {{ old('status', isset($commission->status) ? $commission->status : '')=='active'?'selected="selected"':''}}>Active</option>
                                                                                        <option value="in_active" {{ old('status', isset($commission->status) ? $commission->status : '')=='in_active'?'selected="selected"':''}}>Inactive</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="submit" class="btn btn-info">Update</button>
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                 @if($commission->status=='active')
                                                                     <button style="border: 0;cursor: pointer; background: transparent;" value="{{$commission->status}}" commissionId="{{$commission->id}}" onclick="statusChange()" title="Active"><i class="fa fa-circle text-success"></i></button>
                                                                 @else
                                                                     <button style="border: 0;cursor: pointer; background: transparent;" value="{{$commission->status}}" commissionId="{{$commission->id}}" onclick="statusChange()" title="Inactive"><i class="fa fa-circle text-danger"></i></button>
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
            $('form').parsley();
        });
        $('.setCommission').repeater({
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
        function statusChange() {
            var status = $(event.currentTarget).attr('value');
            var commissionId = $(event.currentTarget).attr('commissionId');
            data='';
            $.ajax({
                method: 'GET',
                url: '{{ route('change-commission-status') }}',
                data: {
                    status : status,
                    commissionId: commissionId,
                },
                dataType: "json",
                success: function (response) {
                    if(response == 1){
                        swal({
                            title: "Success!",
                            text: "Commission Status Changed!",
                            icon: "success",
                        });
                        location.reload();
                    }else{
                        swal({
                            title: "Oops!",
                            text: "Commission Status Changed!",
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