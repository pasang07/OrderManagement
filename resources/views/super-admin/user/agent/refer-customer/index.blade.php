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
                                        <li class="breadcrumb-item"><a href="javascript:">Customer List</a></li>
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
                                            <div class="text-right">
                                                <a href="{{route('refer-customer.create')}}"><button type="button" class="btn btn-dark"><i class="fas fa-plus"></i> Request Customer</button></a>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <ul class="nav nav-tabs" id="CustomerTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active text-uppercase" id="allCustomer-tab" data-toggle="tab" href="#allCustomer" role="tab" aria-controls="allCustomer" aria-selected="true">All Customer</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link text-uppercase" id="requestedCustomer-tab" data-toggle="tab" href="#requestedCustomer" role="tab" aria-controls="requestedCustomer" aria-selected="false">Requested Customer</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="CustomerTabContent" style="-webkit-box-shadow: none;box-shadow: none;">
                                                <div class="tab-pane fade show active" id="allCustomer" role="tabpanel" aria-labelledby="allCustomer-tab">
                                                    <div class="table-responsive">
                                                        <table id="col-reorder1" class="table table-hover todo-list ui-sortable">
                                                            <thead>
                                                            <tr>
                                                                <th>S.N.</th>
                                                                <th>Customer Name</th>
                                                                <th>Status</th>
                                                            </tr>
                                                            </thead>

                                                            <tbody>
                                                            @foreach($allCustomers as $k=>$customer)
                                                                <tr id="{{$customer->id}}">
                                                                    <td>{{$k+1}}</td>
                                                                    <td>
                                                                        <h6 class="mb-1" style="font-weight: 800;">{{$customer->name}}</h6>
                                                                        <p>
                                                                            {{$customer->email}}<br>
                                                                            {{$customer->phone}}<br>
                                                                            {{$customer->address}}
                                                                        </p>
                                                                    </td>
                                                                    <td>
                                                                       @if($customer->is_verified == 1)
                                                                           <i class="fa fa-check-circle text-success"> Verified</i>
                                                                       @else
                                                                            <i class="fa fa-times-circle text-danger"> Not Verified</i>
                                                                       @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="requestedCustomer" role="tabpanel" aria-labelledby="requestedCustomer-tab">
                                                    <div class="table-responsive">
                                                        <table id="col-reorder2" class="table table-hover todo-list ui-sortable">
                                                            <thead>
                                                            <tr>
                                                                <th>S.N.</th>
                                                                <th>Customer Name</th>
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
                                                                        <p>
                                                                            {{$customer->email}}<br>
                                                                            {{$customer->phone}}<br>
                                                                            {{$customer->address}}
                                                                        </p>
                                                                    </td>
                                                                    <td>{{date('d M, Y', strtotime($customer->created_at))}}</td>
                                                                    <td>
                                                                        @if($customer->is_approve == 'no')
                                                                        <a href="{{route('refer-customer.edit',$customer->id)}}" ><button type="button" class="btn btn-icon btn-rounded btn-outline-primary"><i class="fas fa-edit"></i></button></a>
                                                                        <button type="button" class="btn btn-icon btn-rounded btn-outline-danger" data-toggle="modal" data-target="#deleteModal-{{$k}}"><i class="fas fa-trash"></i></button>
                                                                        <!-- delete -->
                                                                        <div class="modal fade" id="deleteModal-{{$k}}" tabindex="-1" role="dialog">
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
                                                                        @else
                                                                            <h6 class="text-success"><i class="fa fa-check-circle"></i> Approved</h6>
                                                                            Approved Date: {{date('d M, Y', strtotime($customer->approve_date))}}<br>
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