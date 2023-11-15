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
                                        <li class="breadcrumb-item"><a href="javascript:">Requested Customers</a></li>
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
                                            <h5>Customers</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table id="col-reorder2" class="table table-hover todo-list ui-sortable">
                                                    <thead>
                                                    <tr>
                                                        <th>S.N.</th>
                                                        <th>Customer Name</th>
                                                        <th>Agent Info</th>
                                                        <th>Requested Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($referCustomers as $k=>$customer)
                                                        <tr id="{{$customer->id}}">
                                                            <td>{{$k+1}}</td>
                                                            <td>
                                                                <h6 class="mb-1" style="font-weight: 800;">{{$customer->name}}</h6>
                                                                @if($customer->email)
                                                                   Email: <a href="mailto:{{$customer->email}}">{{$customer->email}}</a><br>
                                                                @endif
                                                                <p>
                                                                @if($customer->phone) Phone: {{$customer->phone}}<br> @endif
                                                                @if($customer->address) Address: {{$customer->address}} @endif
                                                                </p>

                                                            </td>
                                                            <td>
                                                                <p>{{$customer->agent->name}}</p>
                                                                <p>{{$customer->agent->email}}</p>

                                                            </td>
                                                            <td>
                                                                {{date('d M, Y', strtotime($customer->created_at))}}
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#referApprove-{{$k}}">Approve</button>
                                                                <!-- delete -->
                                                                <div class="modal fade" id="referApprove-{{$k}}" tabindex="-1" role="dialog">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="defaultModalLabel">Approve Customer !!!</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Approve <b>{{$customer->name}}</b> as customer?
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <a href="{{route('admin-refer-customer.approve',$customer->id)}}" class="btn btn-success">Approve</a>
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#referReject-{{$k}}">Reject</button>
                                                                <!-- delete -->
                                                                <div class="modal fade" id="referReject-{{$k}}" tabindex="-1" role="dialog">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="defaultModalLabel">Attention !!!</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Are you sure you want to delete <b>{{$customer->name}}</b>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <a href="{{route('refer-customer.destroy',$customer->id)}}" class="btn btn-danger">Delete</a>
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

@endsection