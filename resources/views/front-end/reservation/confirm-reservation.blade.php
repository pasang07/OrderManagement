@extends('layouts.front-end.layouts')
@section('content')
    <?php
    $room_total_price = Request::segment(3);

    $total_room = Request::segment(4);

    $countries = \CountryState::getCountries();

    $r=Request::segment(2); //room title
    $room_id = json_decode($r);
    $c = Request::segment(9);
    $counted_room = json_decode($c);
    foreach (array_combine($room_id,$counted_room) as $id => $countedRoom) {
        $idcountedRoom[] = array($id,$countedRoom);
    }
    foreach($idcountedRoom as $idcountedRooms)
      {
          $room_details = \App\Models\Model\SuperAdmin\Room\Room::where('id',$idcountedRooms[0])->first();
      }

    ?>

    <section id="single-post" class="bg-color-01 wide-90 blog-page-section division" style="padding: 150px 0;">
        <div class="container">
            <div class="row">
                <!-- POST CONTENT -->
                <div class="col-lg-7 mb-20">
                    <div class="single-blog-post pr-30">
                        <!-- POST TEXT -->
                        <div class="single-post-txt">
                            <!-- Text -->
                            <div class="form-holder">
                                <div class="mb-20">
                                    <h4 class="txt-color-01">Booking Confirmation</h4>
                                    <p>Finish your booking by adding information.<br>
                                        <small>Fields with * are required.</small></p>
                                </div>
                                <form name="contactform" class="row contact-form" autocomplete="off" method="post" action="{{route('reservation.final')}}">
                                    @csrf
                                    <input type="hidden" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" name="booked_date" readonly>
                                    <input type="hidden" id="check_in_date" name="check_in"  value="{{date('Y-m-d', strtotime(Request::segment(5)))}}" readonly><br>
                                    <input type="hidden" id="check_out_date" name="check_out"  value = "{{date('Y-m-d', strtotime(Request::segment(6)))}}" readonly><br>
                                    <input type="hidden" id="stay_length" name="stay_length" value = "{{Request::segment(10)}}" readonly>
                                    <input type="hidden" name="adult_no" value="{{Request::segment(7)}}" readonly>
                                    <input type="hidden" name="child_no" value="{{Request::segment(8)}}" readonly>
                                    <input type="hidden" name="price_format" value="{{Request::segment(11)}}">
                                    <input type="hidden" name="overallRoom"  value="{{$total_room}}">
                                    <input type="hidden" name="overallPrice" value="{{$room_total_price}}">

                                    @foreach($idcountedRoom as $idcountedRooms)
                                    <?php
                                        $room_details = \App\Models\Model\SuperAdmin\Room\Room::where('id',$idcountedRooms[0])->first();
                                    ?>
                                    <input type="hidden" name="eachroomPrice[]" value="{{$room_details->price}}">
                                    <input type="hidden" name="roomName[]" value="{{$room_details->title}}">
                                    <input type="hidden" name="roomId[]" value="{{$room_details->id}}">
                                    <input type="hidden" name="adultNumber[]" value="{{$room_details->adult}}">
                                    <input type="hidden" name="childNumber[]" value="{{$room_details->child}}">
                                    <input type="hidden" name="eachroomPriceFormat[]" value="{{$room_details->price_format}}">
                                    @endforeach

                                    <!-- Form Input -->
                                    <div class="col-md-12 col-12">
                                        <label>Full Name *</label>
                                        <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label>Email *</label>
                                        <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label>Phone Number</label>
                                        <input type="number" name="phone" class="form-control name" placeholder="Phone Number">
                                    </div>
                                    <div class="col-md-6 col-6">
                                        <label>Country *</label>
                                        <select class="form-control" name="country" required>
                                            <option value="">Your Country </option>
                                            @foreach($countries as $country)
                                                <option value="{{$country}}">{{$country}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-6">
                                        <label>Citizenship or Passport</label>
                                        <input type="number" name="identity_no" class="form-control name" placeholder="Citizenship No/ Passport">
                                    </div>
                                    <!-- Form Textarea -->
                                    <div class="col-md-12 col-12">
                                        <label>Special Request [If Any]</label>
                                        <textarea name="message" class="form-control message" rows="4" placeholder="Special Request..."></textarea>
                                    </div>
                                    <!-- Form Button -->
                                    <div class="col-md-12 mt-5">
                                        <button type="submit" class="btn btn-md btn-color-02 tra-02-hover submit">Book Now</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- END POST TEXT -->
                    </div>
                </div>
                <!-- END POST CONTENT -->
                <!-- SIDEBAR -->

                <aside id="sidebar" class="col-lg-5 mt-10">
                    {{--<div class="col-md-12">--}}
                        {{--<img class="img-fluid" src="{{asset('uploads/Room/thumbnail/'.$room_details->image)}}" alt="no-image" style="width: inherit;" />--}}
                    {{--</div>--}}
                    <div class="container">
                        <div class="card" style="border: none;">
                            @foreach($idcountedRoom as $idcountedRooms)
                                <?php
                                $room_details = \App\Models\Model\SuperAdmin\Room\Room::where('id',$idcountedRooms[0])->first();
                                ?>
                                    <div class="col-md-12">
                                    <img class="img-fluid" src="{{asset('uploads/Room/thumbnail/'.$room_details->image)}}" alt="no-image" style="width: inherit;" />
                                    </div>
                            <div class="card-header">
                                <strong>{{$room_details->title}}</strong>
                                @if($room_details->price)<span class="float-right"> <strong>{{$room_details->price_format}} {{$room_details->price}}</strong> Per Night</span>@endif
                            </div>
                            @endforeach
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-sm-6 col-6">
                                        <div>
                                            <strong>Check In Date:</strong><br>
                                            <strong>Check Out Date:</strong>
                                        </div>
                                        <div><strong>Length of Stay:</strong></div>
                                        <div><strong>Guests:</strong></div>
                                    </div>
                                    <div class="col-sm-6 col-6">
                                        <div>
                                            <strong>{{date('d M, Y', strtotime(Request::segment(5)))}}</strong><br>
                                            <strong>{{date('d M, Y', strtotime(Request::segment(6)))}}</strong>
                                        </div>
                                        <div><strong>{{Request::segment(10)}} @if(Request::segment(10) > 1)Nights @elseif(Request::segment(10) == 1) Night @else @endif </strong> </div>
                                        <div><strong>@if(Request::segment(7) > 1){{Request::segment(7)}} Adults @else {{Request::segment(7)}} Adult @endif</strong><br>
                                            @if(Request::segment(8) > 1)<strong> {{Request::segment(8)}} Children</strong> @elseif(Request::segment(8) == 1) <strong> {{Request::segment(6)}} Child</strong> @else @endif
                                        </div>
                                    </div>
                                    <hr width="100%">
                                    <div class="col-sm-6 col-6">
                                        <div>
                                            <strong>Sub Total:</strong>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-6">
                                        <div>
                                            @foreach($idcountedRoom as $idcountedRooms)
                                                <?php
                                                $room_details = \App\Models\Model\SuperAdmin\Room\Room::where('id',$idcountedRooms[0])->first();
                                                $sub = $room_details->price * Request::segment(10);
                                                ?>
                                            <strong>
                                               {{$room_details->price_format}}{{$sub}}<br>
                                            </strong>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr width="100%" style="background: #862020e0;">
                                    <div class="col-sm-6 col-6">
                                        <div>
                                            <strong>Grand Total:</strong>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-6">
                                        <div>
                                            <strong>
                                                <h5>{{Request::segment(11)}}{{Request::segment(3)}}</h5>
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="col-12 text-right">
                                    <p class="text-info">Changing your plans? </p>
                                    <button class="btn btn-sm btn-tra-01 color-02-hover " onclick="history.go(-1)">
                                        Return Back
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>


            <!-- END SIDEBAR -->
            </div>
            <!-- End row -->
        </div>
        <!-- End container -->
    </section>

@stop
@section('page-specific-scripts')
@endsection

