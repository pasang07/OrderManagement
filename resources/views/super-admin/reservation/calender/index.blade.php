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
                                        <li class="breadcrumb-item"><a href="javascript:">Booking Calender</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row">
                                <div class="col-md-4">
                                    <div id='calendar'></div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5><span id="dateChosen">{{date('l, d M Y', strtotime($today_date))}}</span></h5>
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="nav nav-pills reserve-pills" id="pills-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="pills-booked-tab" data-toggle="pill" href="#pills-booked" role="tab" aria-controls="pills-booked" aria-selected="true">Booked</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="pills-confirm-tab" data-toggle="pill" href="#pills-confirm" role="tab" aria-controls="pills-confirm" aria-selected="false">Confirmed</a>
                                                    <span id="currentdate" style="display: none"></span>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="pills-vacant-tab" data-toggle="pill" href="#pills-vacant" role="tab" aria-controls="pills-vacant" aria-selected="false">Vacant</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="tab-content res-tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="pills-booked" role="tabpanel" aria-labelledby="pills-booked-tab">
                                                    <div class="table-responsive">
                                                        <table class="table table-dark">
                                                            <thead>
                                                            <tr>
                                                                <th>Booking No</th>
                                                                <th>Customer Name</th>
                                                                <th>Room Name</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="bookedList">
                                                            @if($booked_data->count()>0)
                                                                @foreach($booked_data as $k=>$reservation)
                                                                    <?php
                                                                    $rooms = json_decode($reservation->room_title);
                                                                    $count = array_count_values($rooms);
                                                                    $value = $reservation->room_quantity;
                                                                    $key = $reservation->room_name;
                                                                    $j=0;
                                                                    ?>
                                                                    @foreach ($count as $key=>$value)
                                                                        <tr id="{{$k}}{{$j}}">
                                                                            <td>{{$reservation->booking_no}}</td>
                                                                            <td>{{$reservation->name}}</td>
                                                                            <td>
                                                                                {{$reservation->room_name}}
                                                                                <p>Room No: {{$reservation->room_no}}</p>
                                                                            </td>
                                                                            <td>
                                                                                <button class="btn btn-info btn-sm confirmed" room_id="{{$reservation->room_id}}"  checkIn="{{$reservation->check_in}}" checkOut="{{$reservation->check_out}}" value="{{$value}}" room_name = "{{$key}}" trow_id="{{$k.$j}}" reservation_id = "{{$reservation->id}}" onclick="confirm()" style="line-height: 0.8;padding: 7px;margin-right: 3px;">Assign Room</button>
                                                                                <button class="btn btn-danger btn-sm booking_release" style="line-height: 0.8;padding: 7px;margin-right: 0;" release_room ="{{$key}}"  trow_releaseId="{{$k}}{{$j}}" onclick="bookingRelease({{$reservation->id}})">Release</button>
                                                                            </td>
                                                                        </tr>
                                                                        @php $j++; @endphp
                                                                    @endforeach
                                                                @endforeach
                                                                {{--@else--}}
                                                                {{--<h5>Sorry! You don't have any reservation for this day.</h5>--}}
                                                            @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="pills-confirm" role="tabpanel" aria-labelledby="pills-confirm-tab">
                                                    <div class="table-responsive">
                                                        <table class="table table-dark" id="confirmedTable">
                                                            <thead>
                                                            <tr>
                                                                <th>Customer Name</th>
                                                                <th>Room Name</th>
                                                                <th>Room No</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="confirmList">
                                                            @foreach($confirmed_data as $cData)
                                                                <tr id="">
                                                                    <td>{{$cData->name}}</td>
                                                                    <td>
                                                                        {{$cData->room_name}}
                                                                    </td>
                                                                    <td>
                                                                        {{$cData->room_no}}
                                                                    </td>
                                                                    <td>
                                                                        <button class="btn btn-info btn-sm" style="line-height: 0.8;padding: 7px;" onclick="confirmDetails({{$cData->id}})">Details</button>
                                                                        <button class="btn btn-danger btn-sm" style="line-height: 0.8;padding: 7px;"  data-toggle="modal" data-target="#modal-release{{$cData->id}}">Release</button>

                                                                        {{--Releasing Confirm Modal--}}

                                                                        <div class="modal fade" id="modal-release{{$cData->id}}" tabindex="-1">
                                                                            <div class="modal-dialog modal-dialog-centered">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h4 class="modal-title">Confirmed Room Release</h4>
                                                                                    </div>
                                                                                    <div class="modal-body" style="padding: 15px 30px !important;">
                                                                                        <div style="border-top: 2px solid;border-bottom: 2px solid;text-align:left;">
                                                                                            <div class="col-md-12">
                                                                                                <label style="font-weight: bold;background: #a93927;border-radius: 3px;padding: 2px;margin-top: 15px;">Any Reason For Releasing Room?&nbsp;&nbsp;</label><br>
                                                                                            </div>
                                                                                            <div class="col-md-12">
                                                                                                <div class="form-group">
                                                                                                    <textarea name="vacant_special_request" id="vacant_srequest" row="5" cols="7" class="form-control textarea-autosize" placeholder="Start typing..." style="height:100px;"></textarea>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button class="btn btn-danger btn--icon-text" style="line-height: 0.8;width: auto;padding: 7px;" row_id ="{{$cData->id}}" onclick="confirmRelease({{$cData->room_id}},{{$cData->id}})"  data-dismiss="modal">Confirm Release</button>
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

                                                <div class="tab-pane fade" id="pills-vacant" role="tabpanel" aria-labelledby="pills-vacant-tab">
                                                    <div class="table-responsive">
                                                        <table class="table table-dark" id="vacantTable">
                                                            <thead>
                                                            <tr>
                                                                <th>Room Name</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="vacantList">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- Room Assign Modal -->
                                                <div class="modal fade" id="assignRoomModal" tabindex="-1" role="dialog" aria-labelledby="assignRoomModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="assignRoomModalLabel">Booking Confirmations</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body" style="color: #212529;">
                                                            </div>
                                                            <div class="modal-footer">
                                                                {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
                                                                <button type="button" class="btn btn-primary" onclick="submitConfirm()">Assign Room</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Confirmed Detail Modal Data -->
                                                <div class="modal fade" id="confirmedDetails" tabindex="-1">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            {{--<div class="modal-header">--}}
                                                                {{--<h5 class="modal-title">Informations</h5>--}}
                                                                {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
                                                            {{--</div>--}}
                                                            <div class="modal-body" style="color: #212529;">

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                </div>
            </div>
        </div>
    </section>

@endsection
