@extends('layouts.front-end.layouts', ['pagetitle'=> 'Search Availability'])
@section('content')

    <section id="about-9" style="padding: 150px 0;">
        <div class="bg-inner division">
            <div class="container">
                <!-- SECTION TITLE -->
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="section-title mb-60 text-center">
                            <h4 class="h4-sm txt-color-01">Available Rooms</h4>
                            <!-- Text -->
                            <p class="p-lg txt-color-01">Spend your quality time with our best available rooms.</p>

                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-12 col-md-12 col-12">
                        <form method="post" data-route="{{route('room-reservation')}}" id="post-form" autocomplete="off">
                            {!! csrf_field() !!}
                            <div id="room">
                                <input type="hidden" id="totalNumber" value = "{{$available_rooms->count()}}">
                                <div class="mb-20">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <b>Check In Date</b><br>
                                            <input type="text" name="checkIn" id="ci" class="form-control" value="{{$check_In}}" disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <b>Check Out Date</b><br>
                                            <input type="text" name="checkOut" id="co" class="form-control" value="{{$check_Out}}" disabled>
                                            <span style="display: none;"><span id="night_no_single">{{$length_of_stay}}</span> Night</span>
                                        </div>
                                        <div class="col-md-3">
                                            <b>No of Adult</b><br>
                                            <input class="form-control" id="an" name="adult_number" type="number" value="{{$adult}}" disabled>
                                        </div>
                                        <div class="col-md-3">
                                            <b>No of Child</b><br>
                                            <input class="form-control" id="cn" name="child_number" type="number" value="{{$child}}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-bordered table-respon">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col-1">Room Type</th>
                                        <th scope="col-1">Sleeps</th>
                                        <th scope="col-2">Price per night</th>
                                        <th scope="col-2">Select rooms</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($available_rooms)
                                        @foreach($available_rooms as $k=>$room)
                                            <tr>
                                                <th scope="row">
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item"><a href="" >{{$room->title}} <i class="fa fa-picture-o"></i></a></li>
                                                    </ul>
                                                </th>
                                                <td class="text-center">
                                                    <?php
                                                    $totPeople = $room->adult + $room->child;
                                                    ?>
                                                    @if($totPeople == 1) <i class="fa fa-male" style="color:#dfa839;"> @elseif($totPeople == 2) <i class="fa fa-male" style="color:#dfa839;"></i><i class="fa fa-male" style="color:#dfa839;"></i></i> @else <i class="fa fa-male" style="color:#dfa839;"></i> X {{$totPeople}} @endif
                                                    <br>
                                                    <small>{{$room->adult}} Adults @if($room->child > 0), {{$room->child}} Child @endif</small>
                                                </td>
                                                <td><?php
                                                    $prs = $room->price * $length_of_stay;
                                                    ?>
                                                    <span id="priceFormat">{{$room->price_format}}</span><span id="perprice{{$k}}" value = "{{$prs}}">{{$prs}}</span>
                                                    <br>
                                                    For <span class="night_no">{{$length_of_stay}}</span> @if($length_of_stay > 1)Nights @else Night @endif
                                                    <br><small>(Includes Tax & Vat)</small>
                                                </td>
                                                <td class="text-center">
                                                    <span id="roomcount{{$loop->iteration}}" value="{{$room->room_count}}" style="display:none;"></span>
                                                    <?php
                                                    $starts = \Carbon\Carbon::parse($start)->format('Y-m-d');
                                                    $ends = \Carbon\Carbon::parse($end)->format('Y-m-d');

                                                    $overallRoom = \App\Models\Model\SuperAdmin\Room\RoomNo::where('room_id',$room->id)
                                                        ->get()->count();

                                                    $reservedRoomCount = \App\Models\Model\SuperAdmin\Reservation\Reservation::where('room_id',$room->id)->where(function($query) use ($check_In,$check_Out){
                                                        $query->whereBetween('check_in', [$check_In,$check_Out])
                                                            ->orWhere('check_out','>=', $check_In)
                                                            ->where('check_in','<=', $check_In);
                                                    })->get()->count();

                                                    $confirmedRoomCount = \App\Models\Model\SuperAdmin\Reservation\ReservationConfirm::where('room_id',$room->id)
                                                        ->where(function($query) use ($check_In,$check_Out){
                                                            $query->whereBetween('check_in', [$check_In,$check_Out])
                                                                ->orWhere('check_out','>=', $check_In)
                                                                ->where('check_in','<=', $check_In);
                                                        })->get()->count();

                                                    $a = $reservedRoomCount + $confirmedRoomCount;
                                                    $availableRoom = $overallRoom  - $a;
                                                    ?>
                                                    @if($availableRoom > 0)
                                                        <select class="form-control room" name="total_room-{{$k}}" id="room_quantity{{$loop->iteration}}" onchange="roomFunction({{$loop->iteration}})" >
                                                            <?php
                                                            for ($i=0; $i<=$availableRoom; $i++)
                                                            {   if($room->price){

                                                                $pd = $i * $room->price;
                                                            }
                                                                if($i == 0){
                                                                    echo "<option roomname=''  roomno='$i' orgprice='$prs' roomprice='$prs' id='{$loop->iteration}asd$i' value='$i'>".$i."</option>";
                                                                }
                                                                else{
                                                                    echo "<option roomname='$room->id' adultsize='$room->adult' childsize='$room->child'  roomno='$i'  orgprice='$prs' roomprice='$prs' id='{$loop->iteration}asd$i' value='$i'>".$i."</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    @else
                                                        <input class="noRoomLeft form-control"value="Sorry!! No room left." size="10" readonly>
                                                    @endif
                                                    @if($availableRoom > 2)
                                                        <span class="roomLeftInfo text-success">{{$availableRoom}} rooms available!!</span>
                                                    @elseif($availableRoom == 0 || $availableRoom == 1)
                                                        <span class="roomLeftInfo text-danger"></span>
                                                    @else
                                                        <span class="roomLeftInfo text-danger">{{$availableRoom}} room available.</span>
                                                    @endif
                                                    <h5 style="display:none;">Price <span id="span{{$loop->iteration}}"></span> Room <span id="priceSpan{{$loop->iteration}}"></span>
                                                        RoomID <span id="roomSpan{{$loop->iteration}}"></span>Adult <span id="adultSpan{{$loop->iteration}}"></span>Child <span id="childSpan{{$loop->iteration}}"></span>
                                                    </h5>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                <div class="res">
                                    <div class="enableButton" id="enable" style="display:none;">
                                        <div class="row">
                                            <div class="reserve-head col-7">
                                                Total Room: <span id="roomTotal"></span><br>
                                                Total Price: <span id="grandTotal"></span><br>
                                                <span id="adults" style="display:none;"></span>
                                                <span id="childs" style="display:none;"></span>
                                                <span id="roomId" style="display:none;"></span>
                                                <span id="countedRoom" style="display:none;"></span>
                                                <small>includes taxes and charges</small>
                                            </div>
                                            <div class="col-5" >
                                                <button class="btn btn-sm btn-color-02" type="submit">Reserve</button>
                                                <p>You'll be taken to the next step</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="disableButton">
                                        <div  id="disable" style="">
                                            <a class="btn btn-sm btn-color-02" disable style="cursor: not-allowed; color:#fff;">Reserve</a>
                                            <p>Select room to reserve</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <!-- End row -->
            </div>
            <!-- End container -->
        </div>
    </section>
@endsection

<script src="{{asset('resources/front-end/js/jquery-3.4.1.min.js')}}"></script>

<script type="text/javascript">
    function roomFunction(id){
        var room = '#room_quantity'+id;
        $(room).on('click',function(){
            var selectedRoom = $('option:selected', this).attr('id');
            var roomname = $('#'+selectedRoom).attr('roomname');
            var priceRoom = $('#'+selectedRoom).attr('roomprice');
            var countRoom = $('#'+selectedRoom).attr('roomno');
            var adultsize = $('#'+selectedRoom).attr('adultsize');
            var childsize = $('#'+selectedRoom).attr('childsize');

            $('#span'+id).html(priceRoom);
            $('#priceSpan'+id).html(countRoom);
            $('#roomSpan'+id).html(roomname);
            $('#adultSpan'+id).html(adultsize);
            $('#childSpan'+id).html(childsize);
            var i;
            var count = parseInt(document.getElementById('totalNumber').value);
            var grandTotal = 0;
            var adults = 0;
            var childs = 0;
            var roomTotal = 0;
            var room_id ='';
            var counted_room='';
            var roomidArray = new Array();
            var countedroomArray = new Array();

            for(i=1;i<=count;i++){
                adults += parseInt(+$('#adultSpan'+i).html());
                childs += parseInt(+$('#childSpan'+i).html());
                grandTotal += parseInt(+$('#span'+i).html());
                roomTotal += parseInt(+$('#priceSpan'+i).html());
                room_id =$('#roomSpan'+i).html();
                roomidArray.push(room_id);
                counted_room =$('#priceSpan'+i).html();
                countedroomArray.push(counted_room);
            }
            //filtering empty array
            var filteredRoom = roomidArray.filter(function (el) {
                return el != null && el != "";
            });

            //filtering empty counted roomarray
            var filteredcountedRoom = countedroomArray.filter(function (el) {
                return el != null && el != "" && el != 0;
            });

            var a = JSON.stringify(filteredRoom);
            var c_room = JSON.stringify(filteredcountedRoom);
            if(roomTotal == 0){
                document.getElementById("disable").style.display = "inline";
                document.getElementById("enable").style.display = "none";
            }
            else{
                document.getElementById("disable").style.display = "none";
                document.getElementById("enable").style.display = "inline";
            }
            $('#grandTotal').html(grandTotal);
            $('#adults').html(adults);
            $('#childs').html(childs);
            $('#roomTotal').html(roomTotal);
            $('#roomId').html(a);
            $('#countedRoom').html(c_room);
        });
    }
</script>

<script type="text/javascript">
    $(document).on('submit', 'form#post-form', function (event) {
        var route = $('#post-form').data('route');
        var form = $(this);
        var totalRoom = $("#roomTotal").text();
        var totalPrice = $("#grandTotal").text();
        var selectedRoomId = $("#roomId").text();
        var countedRoom = $('#countedRoom').text();
        var night = $('#night_no_single').text();
        var priceFormat = $('#priceFormat').text();
        var checkIn = $('#ci').val();
        var checkOut = $('#co').val();
        var adult  = $("#adults").text();
        var child  = $("#childs").text();
        var adult_number = $('#an').val();
        var child_number = $('#cn').val();

        if(adult_number > adult){

            alert(adult_number + ' People will not fitted here. So please select room.');
        }else{
            $.ajax({
                type: "POST",
                url: route,
                data: {
                    "_token": "{{ csrf_token() }}",
                    formdata : $("form").serialize(),
                    totalRoom:totalRoom,
                    checkIn:checkIn,
                    checkOut:checkOut,
                    adult_number:adult_number,
                    child_number:child_number,
                    totalPrice: totalPrice,
                    selectedRoomId:selectedRoomId,
                    countedRoom:countedRoom,
                    night:night,
                    priceFormat:priceFormat,
                },
                success:function(response){
                    var selectedRomId =encodeURIComponent(response.selectedRoomId);
                    var totalPrice =encodeURIComponent(response.totalPrice);
                    var checkIn =encodeURIComponent(response.checkIn);
                    var checkOut =encodeURIComponent(response.checkOut);
                    var adult_number =encodeURIComponent(response.adult_number);
                    var child_number =encodeURIComponent(response.child_number);
                    var night =encodeURIComponent(response.night);
                    var totalRoom = encodeURIComponent(response.totalRoom);
                    var countedRoom = encodeURIComponent(response.countedRoom);
                    var priceFormat = encodeURIComponent(response.priceFormat);
                    var url = "{{url('reservation')}}"+"/"+selectedRomId+"/"+totalPrice+"/"+totalRoom+"/"+checkIn+"/"+checkOut+"/"+adult_number+"/"+child_number+"/"+countedRoom+"/"+night+"/"+priceFormat;
//                    console.log(url);
                    window.location.href = url;
                }
            });
        }

        event.preventDefault();
    });

    if(!!window.performance && window.performance.navigation.type ===2){
        console.log('Reloading');
        window.location.reload();
    }
</script>