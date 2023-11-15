<section id="hero-4" class="hero-section division">
    <div class="slideshow">
        <div class="slideshow-inner">
            <!-- SLIDER -->
            <div class="slides">
                @foreach($room_sliders as $r=>$room_slider)
                    <div class="slide @if($r == 0) is-active @endif">
                        <!-- Slide Content -->
                        <div class="slide-content shadowImage">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="caption white-color">
                                            {{--<h3 class="h3-md">Explore Our Rooms</h3>--}}
                                            {{--<div class="text-white">--}}
                                            {{--Starting From $110/ night--}}
                                            {{--</div>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Slide Content -->
                        <!-- Slide Background Image -->
                        <div class="image-container">
                            <img class="img-fluid bigslider" src="{{asset('uploads/RoomSlider/thumbnail/'.$room_slider->image)}}" alt="slide-background">
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- END SLIDER -->
            <!-- SLIDER ARROWS -->
            {{--<div class="arrows ico-45 white-color">--}}
            {{--<div class="arrow prev"><span class="flaticon-back"> </span></div>--}}
            {{--<div class="arrow next"><span class="flaticon-next"> </span></div>--}}
            {{--</div>--}}
        </div>
        <!-- End Slideshow Inner -->
    </div>
    <!-- End Slideshow -->
</section>