@extends('layouts.front-end.layouts', ['pagetitle'=> 'Room Booking Successful'])
@section('content')
    <section id="about-9" style="padding: 150px 0;">
        <div class="bg-inner division">
            <div class="container">
                <div class="row d-flex align-items-center">

                    <!-- TEXT BLOCK -->
                    <div class="col-md-12 col-lg-12 text-center">
                        <div style="margin: 0 0 20px 0;">
                            <img src="{{asset('resources/front-end/images/logo-dark.png')}}" style="width: 230px">
                        </div>
                        <div class="txt-block pc-15">

                            <h4 class=" txt-color-01">Thank You for booking with us. We'll See You Soon.</h4>
                            <!-- Title -->
                            <p class=" txt-color-01">Our staff will be in contact with you shortly for final confirmation.<br>
                                If you need immediate response please call us on <a href="tel:9860041338">9860041338</a>.
                            </p>

                            <a href="{{route('home.index')}}" type="button" class="btn btn-sm btn-color-02">Go To Home</a>
                        </div>
                    </div>	<!-- END TEXT BLOCK -->
                </div>	  <!-- End row -->
            </div>	   <!-- End container -->
        </div>
    </section>
@stop