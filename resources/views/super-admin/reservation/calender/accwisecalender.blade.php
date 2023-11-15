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
                                            <h5><span id="dateChosen">{{date('l, d F Y', strtotime($today_date))}}</span></h5>
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
                                                {{--<li class="nav-item">--}}
                                                    {{--<a class="nav-link" id="pills-vacant-tab" data-toggle="pill" href="#pills-vacant" role="tab" aria-controls="pills-vacant" aria-selected="false">Vacant</a>--}}
                                                {{--</li>--}}
                                            </ul>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="tab-content res-tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="pills-booked" role="tabpanel" aria-labelledby="pills-booked-tab">
                                                    <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                                                        <table class="table table-dark" >
                                                            <thead>
                                                            <tr>
                                                                <th>Customer</th>
                                                                <th>Room Name</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="bookedList">
                                                            @if($booked_data->count()>0)
                                                                @foreach($booked_data as $k=>$reservation)
                                                                    <?php
                                                                    $j=0;
                                                                    ?>
                                                                        <tr id="{{$k}}{{$j}}">
                                                                            <td>{{$reservation->name}}</td>
                                                                            <td>
                                                                            {{$reservation->room_title}}
                                                                            </td>
                                                                            <td>
                                                                                <button class="btn btn-info btn-sm confirmed"  checkIn="{{$reservation->check_in}}" checkOut="{{$reservation->check_out}}" room_id ="{{$reservation->room_id}}"  room_name = "{{$reservation->room_title}}" trow_id="{{$k.$j}}" reservation_id = "{{$reservation->id}}" onclick="confirm()" style="line-height: 0.8;padding: 7px;margin-right: 3px;">Confirm</button>
                                                                                <button class="btn btn-danger btn-sm booking_release" style="line-height: 0.8;padding: 7px;margin-right: 0;" booking_no="{{$reservation->booking_no}}" room_id ="{{$reservation->room_id}}"  trow_releaseId="{{$k}}{{$j}}" onclick="bookingReleaseModal({{$reservation->id}})">Cancel</button>
                                                                            </td>
                                                                        </tr>
                                                                        @php $j++; @endphp
                                                                @endforeach
                                                                @else
                                                                <tr><td colspan="4">Sorry! No Bookings for this day.</td></tr>
                                                            @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                {{--Confirmed Tab--}}
                                                <div class="tab-pane fade" id="pills-confirm" role="tabpanel" aria-labelledby="pills-confirm-tab">
                                                    <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                                                        <table class="table table-dark mb-0" id="confirmedTable">
                                                            <thead>
                                                            <tr>
                                                                <th>Booking No#</th>
                                                                <th>Customer Name</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="confirmList">
                                                            @foreach($confirmed_data as $k=>$cData)
                                                                <?php
                                                                $room_Name=wordwrap($cData->room_title,28,"<br />\n", false);
                                                                $j=0;
                                                                ?>
                                                                <tr id="{{$k}}{{$j}}">
                                                                    <input type="hidden" id="b_no" value="{{$cData->booking_no}}">
                                                                    <td class="text-uppercase ">{{$cData->booking_no}}</td>
                                                                    <td>{{$cData->name}}</td>
                                                                    <td>
                                                                        <button class="btn btn-info btn-sm" style="line-height: 0.8;padding: 7px; " booking_no="{{$cData->booking_no}}" trow_checkoutId="{{$k}}{{$j}}"  onclick="confirmDetails({{$cData->id}})"> Check Out </button>
                                                                    </td>
                                                                </tr>
                                                                @php $j++; @endphp
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="pills-vacant" role="tabpanel" aria-labelledby="pills-vacant-tab">
                                                    <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                                                        <table class="table table-dark" id="vacantTable">
                                                            <thead>
                                                            <tr>
                                                                <th>Room Name</th>
                                                                <th>Booking Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="vacantList">
                                                            @foreach($vacant_data as $k=>$vData)
                                                                <?php
                                                                $room_Title=wordwrap($vData->title,30,"<br />\n", false);

                                                                $start = \Carbon\Carbon::now()->format('Y-m-d');
                                                                $end = \Carbon\Carbon::tomorrow()->format('Y-m-d');

                                                                $overallRoom = \App\Models\Model\SuperAdmin\Room\RoomNo::where('room_id',$vData->id)->get()->count();

                                                                $reservedRoomCount = \App\Models\Model\SuperAdmin\Reservation\Reservation::where('room_id',$vData->id)
                                                                    ->where(function($query) use ($start,$end){
                                                                    $query->whereBetween('check_in', [$start,$end])
                                                                        ->orWhere('check_out','>=', $start)
                                                                        ->where('check_in','<=', $start);
                                                                })->get()->count();

                                                                $confirmedRoomCount = \App\Models\Model\SuperAdmin\Reservation\ReservationConfirm::where('room_id',$vData->id)
                                                                    ->where(function($query) use ($start,$end){
                                                                        $query->whereBetween('check_in', [$start,$end])
                                                                            ->orWhere('check_out','>=', $start)
                                                                            ->where('check_in','<=', $start);
                                                                    })->get()->count();

                                                                $a = $reservedRoomCount + $confirmedRoomCount;
                                                                $v = $overallRoom  - $a;
                                                                ?>
                                                                <tr id="">
                                                                    <td>@php echo "$room_Title <br>"@endphp</td>
                                                                    <td>
                                                                        <button class="btn btn-primary btn-sm vacant" trow_id="{{$k}}"  room_id ="{{$vData->id}}" room_title ="{{$vData->title}}" onclick="vacant()" @if($v == 0) disabled style="cursor: not-allowed;" @endif >Walk in (Direct)</button>
                                                                        <button class="btn btn-secondary btn-sm manual" trow_id="{{$k}}"  room_id ="{{$vData->id}}" room_title ="{{$vData->title}}" onclick="manual()" @if($v == 0) disabled style="cursor: not-allowed;" @endif >Manual</button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
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
                                                                {{--<h5 class="modal-title">Information</h5>--}}
                                                                {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
                                                            {{--</div>--}}
                                                            <div class="modal-body" style="color: #212529;">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" onclick="checkOutNow()">Check Out Now</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Vacant Room Modal -->
                                                <div class="modal fade" id="vacantRoomModal" tabindex="-1" role="dialog" aria-labelledby="vacantRoomModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="vacantRoomModalLabel">Booking Confirmations</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body" style="color: #212529;">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-primary" onclick="vacantConfirm()">Confirm Booking</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Manual Room Modal -->
                                                <div class="modal fade" id="manualBookModal" tabindex="-1" role="dialog" aria-labelledby="manualBookModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="manualBookModalLabel">Manual Bookings</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body" style="color: #212529;">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-primary" onclick="manualConfirm()">Book Room</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- Before release password Modal -->
                                                <div class="modal fade" id="releaseModal" tabindex="-1" role="dialog" aria-labelledby="manualBookModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="releaseModalModalLabel">Releasing Booked Room</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body" style="color: #212529;">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" onclick="bookingRelease()">Release Now</button>
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
