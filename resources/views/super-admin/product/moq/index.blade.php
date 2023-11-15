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
                                        <li class="breadcrumb-item"><a href="javascript:">Order Quantity</a></li>
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
                                            <h5>MOQ List</h5>
                                        </div>
                                        <div class="button-card text-right ">
                                            <a href="{{route('moq.create')}}"><button type="button" class="btn btn-dark"><i class="fas fa-plus"></i> Create MOQ</button></a>
                                            {{--<div class="btn-group mb-2 mr-2">--}}
                                                {{--<button type="button" class="btn btn-danger">Action</button>--}}
                                                {{--<button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="sr-only">Toggle Dropdown</span></button>--}}
                                                {{--<div class="dropdown-menu">--}}
                                                    {{--<a class="dropdown-item" id="active" href="#!" data-id="moq">Enable</a>--}}
                                                    {{--<a class="dropdown-item" id="deactive" href="#!" data-id="moq">Disable</a>--}}
                                                    {{--<a class="dropdown-item" id="delete" href="#!" data-id="moq">Delete</a>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table id="sortable" class="table table-hover todo-list ui-sortable showMoreLessTable">
                                                    <thead>
                                                    <tr>
                                                        <th>S.N.</th>
                                                        <th>Product</th>
                                                        <th>MOQ </th>
                                                        <th>Rate Per Bottle [{{$site_data->currency_format}}]</th>
                                                        <th>Modified Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($moqs as $k=>$moq)
                                                        <tr class="unread" id="{{$moq->id}}">
                                                           <td>{{$k+1}}</td>
                                                            <td>
                                                                <h6 class="mb-1">{{$moq->product->title}}</h6>
                                                                <p>
                                                                    {{$moq->batch_no}} ML <br>
                                                                    {{$moq->bottle_case}} {{$site_data->product_type}} <br>
                                                                </p>
                                                            </td>
                                                            <td>
                                                               {{$moq->moq_low}} - {{$moq->moq_high}}
                                                            </td>
                                                            <td>
                                                                {{$moq->rate}}

                                                            </td>
                                                            {{--<td>--}}
                                                                {{--{{$moq->amount}}--}}

                                                            {{--</td>--}}
                                                            <td>
                                                                <h6 class="text-muted">Updated: {{date('d M, Y', strtotime($moq->updated_at))}}</h6>
                                                                <h6 class="text-muted">Created: {{date('d M, Y', strtotime($moq->created_at))}}</h6>
                                                            </td>
                                                            <td>

                                                                <a href="{{route('moq.edit',$moq->id)}}" ><button type="button" class="btn btn-icon btn-rounded btn-outline-primary"><i class="fas fa-edit"></i></button></a>
                                                                <button type="button" class="btn btn-icon btn-rounded btn-outline-danger" data-toggle="modal" data-target="#deleteModal-{{$k}}"><i class="fas fa-trash"></i></button>

                                                                <!-- delete -->
                                                                <div class="modal fade" id="deleteModal-{{$k}}" tabindex="-1" role="dialog">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="defaultModalLabel">Attention !!!</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Are you sure you want to delete this?
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <a href="{{route('moq.destroy',$moq->id)}}" class="btn btn-danger">Delete</a>
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="justify-content-center">
                                                    <ul class="pagination">
                                                        {!! $moqs->render() !!}
                                                    </ul>
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

@endsection