<!-- HERO-4============================================= -->
@if($upcoming_events->count()>0))
<section id="hero-4" class="hero-section division">
    <div class="slideshow">
        <div class="slideshow-inner">
            <!-- SLIDER -->
            <div class="slides">
            @foreach($upcoming_events as $ue=>$upcoming_event)
                <!-- SLIDE #1 -->
                    <div class="slide @if($ue== 0) is-active @endif">
                        <!-- Slide Content -->
                        <div class="slide-content text-left shadowImage">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="caption white-color">
                                            <span>Upcoming Event</span>
                                            <h3 class="h3-md">{{$upcoming_event->title}}</h3>
                                            <div class="text float-left">
                                                <span>{{date('d M, Y', strtotime($upcoming_event->start_date))}}</span>
                                                <br>
                                                <br>
                                                <a href="{{route('event-single', $upcoming_event->slug)}}" class="btn btn-sm btn-color-02 tra-white-hover">
                                                    View Event Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Slide Content -->
                        <!-- Slide Background Image -->
                        <div class="image-container">
                            <img class="img-fluid bigslider" src="{{asset('uploads/Event/thumbnail/'.$upcoming_event->image)}}" alt="Image Not Found">
                        </div>
                    </div>
                    <!-- END SLIDE #1 -->
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
@endif