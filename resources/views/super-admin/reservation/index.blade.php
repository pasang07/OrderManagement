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
                                        <li class="breadcrumb-item"><a href="javascript:">Booking</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ breadcrumb ] end -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <form method="post" action="{{route('reservation.mail')}}" enctype="multipart/form-data" autocomplete="off">
                                @csrf<input type="submit" class="btn btn-dark" value="Send Mail">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <!-- [ configuration table ] start -->
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Booking List</h5>
                                        </div>
                                        <div class="button-card text-right ">
                                            <div class="btn-group mb-2 mr-2">
                                                <button type="button" class="btn btn-danger">Action</button>
                                                <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="sr-only">Toggle Dropdown</span></button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" id="delete" href="#!" data-id="reservation">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table id="sortable" class="table table-hover todo-list ui-sortable">
                                                    <thead>
                                                    <tr>
                                                        <th>S.N.</th>
                                                        <th>Trip</th>
                                                        <th>Customer Name</th>
                                                        <th>Tour Type</th>
                                                        <th>Action</th>
                                                        <th><div class="custom-control custom-checkbox select-all">
                                                                <input type="checkbox" id="checkAll" class="custom-control-input">
                                                                <label class="custom-control-label" for="checkAll"></label>
                                                            </div></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($reservations as $k=>$reservation)
                                                        <tr id="{{$reservation->id}}">
                                                            <td>{{$k+1}}</td>
                                                            <td>
                                                                @if($reservation->listing_departure_date)
                                                                
                                                                <h6 class="mb-1">{{$reservation->trip->title}} - <span class="bg-red" style="background: red;color: #fff;padding: 3px;font-size:12px;">Best Deals</span></h6> 
                                                               
                                                                @else
                                                                 <h6 class="mb-1">{{$reservation->trip->title}}</h6>
                                                                 @endif
                                                            </td>
                                                            <td>
                                                               {{$reservation->name}}
                                                               <p>Contact: {{$reservation->contact_no}}
                                                               <br>Email: {{$reservation->email}}
                                                                 <br>Booked Date: {{date('d M Y', strtotime($reservation->created_at))}}</p>
                                                            </td>
                                                            <td>
                                                                @if($reservation->tour_type == 'private_tour')
                                                                Private Tour
                                                                @else
                                                                Group Tour
                                                                @endif
                                                                <p>Group Size : {{$reservation->group_size}}</p>
                                                              
                                                            </td>
                                                         
                                                            <td><i class="fas fa-info-circle" data-toggle="modal" data-target="#detailsModal-{{$k}}"></i> <i class="fas fa-trash" data-toggle="modal" data-target="#deleteModal-{{$k}}"></i>
                                                                <!-- details -->
                                                                <div class="modal fade" id="detailsModal-{{$k}}" tabindex="-1" role="dialog">
                                                                    <div class="modal-dialog modal-lg" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="defaultModalLabel">Booking Details</h4>
                                                                            </div>
                                                                                <div class="card-body">
                                                                                    <div class="row">
                                                                                        <div class="col-md-6">
                                                                                            <h5 >Booking Info</h5>
                                                                                            <div class="form-group">
                                                                                                <b><label>Name : </label></b>
                                                                                                <span>{{$reservation->name}}</span>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <b><label>Contact No : </label></b>
                                                                                                <span>{{$reservation->contact_no}}</span>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <b><label>Group Size : </label></b>
                                                                                                <span>{{$reservation->group_size}}</span>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <b><label>E-mail : </label></b>
                                                                                                <span>{{$reservation->email}}</span>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <b><label>Address : </label></b>
                                                                                                <span>{{$reservation->address}}</span>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <b><label>Country : </label></b>
                                                                                                <span>{{$reservation->country}}</span>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <b><label>Message : </label></b>
                                                                                                <span>{{$reservation->message}}</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <h5 >Trip Info @if($reservation->customize=='yes') (Customized Trip) @endif</h5>
                                                                                            <div class="form-group">
                                                                                                <b><label>Trip : </label></b>
                                                                                                <span>{{$reservation->trip->title}}</span>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <b><label>Arrival Date : </label></b>
                                                                                                <span>{{date('d M Y', strtotime($reservation->arrival_date))}}</span>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <b><label>Departure Date : </label></b>
                                                                                                <span>{{date('d M Y', strtotime($reservation->departure_date))}}</span>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <b><label>Booked Date : </label></b>
                                                                                                <span>{{date('d M Y', strtotime($reservation->created_at))}}</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                    </div>
                                                                                </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- delete -->
                                                                <div class="modal fade" id="deleteModal-{{$k}}" tabindex="-1" role="dialog">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="defaultModalLabel">Attention !!!</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Are you sure you want to delete <b>{{$reservation->name}}</b>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <a href="{{route('reservation.destroy',$reservation->id)}}" class="btn btn-danger">Delete</a>
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td><div class="custom-control custom-checkbox select-1">
                                                                    <input type="checkbox" class="custom-control-input" id="customCheck{{$reservation->id}}" name="id" value="{{$reservation->id}}">
                                                                    <label class="custom-control-label" for="customCheck{{$reservation->id}}"></label>
                                                                </div></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="justify-content-center">
                                                    <ul class="pagination">
                                                        {!! $reservations->render() !!}
                                                    </ul>
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
        </div>
    </section>
@stop
@section('page-specific-scripts')
@endsection