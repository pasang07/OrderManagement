@extends('layouts.front-end.layouts', ['pagetitle'=> 'Websites'])
@section('content')
    <section class="page-title" style="background:none;height: 200px;">
        <div class="page-title-container">
            <div class="page-title-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col col-xs-12">
                            <h2 style="font-size:2.2rem;">Websites</h2>
                            <ol class="breadcrumbb">
                                <li><a href="{{route('home.index')}}">Home</a></li>
                                <li><a href="{{route('all.product')}}">Product</a></li>
                                <li>Websites</li>
                            </ol>
                        </div>
                    </div> <!-- end row -->
                </div> <!-- end container -->
            </div>
        </div>
        <div class="glass-effect2"></div>
    </section>
    <section class="service-pg-section section-padding" style="padding-top:0;">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <div class="row">
                        @foreach($websites as $website)
                            <div class="col-md-4 col-md-offset-6 content">
                                <div  class="scrollbar" id="style-3">
                                    <img src="{{asset('uploads/Website/thumbnail/'.$website->image)}}">
                                </div>

                                <h5 class="website-txt text-center">{{$website->title}}</h5>
                            </div><!--content-->
                        @endforeach
                    </div>
                </div>
            </div>
        </div> <!-- end container -->
    </section>
    <!-- start service-single-section -->
    <section class="service-single-section section-padding" style="padding-top: 0;">
        <div class="container">
            <div class="row">
                <div class="col col-xl-8 col-12 order-last">
                    <div class="service-single-content">
                        @if($websiteFaqs->count()>0)
                            <h4>FAQ</h4>
                            <div id="accordion" class="accordion">
                                <div class="card mb-0" style="background: transparent; border:0;">
                                    @foreach($websiteFaqs as $f=>$faq)
                                        <div class="card-header collapsed" data-toggle="collapse" href="#collapse{{$f}}" style="border-bottom: 1px solid #4d4d4d63;">
                                            <a class="card-title">
                                                {{$faq->question}}
                                            </a>
                                        </div>
                                        <div id="collapse{{$f}}" class="card-body collapse" data-parent="#accordion" >
                                            <p>
                                                {{$faq->answer}}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col col-xl-4 order-fast">
                    <div class="service-sidebar">
                        <div class="widget contact-widget" style="background: #000;">
                            <div>
                                <h4>Build your own website</h4>
                                <p>Contact us to get more info</p>
                                <a href="{{route('contact-us.index')}}">Contact Now</a>
                                <br>
                                <br>
                                <p>Or Call Us </p>
                                <a href="tel:{{$site_data->mobile_no_2}}" style="padding:0;background:transparent;color:#67b67d;font-size:0.6rem;">{{$site_data->mobile_no_2}}</a>,
                                <a href="tel:{{$site_data->mobile_no}}" style="padding:0;background:transparent;color:#67b67d;font-size:0.6rem;">{{$site_data->mobile_no}}</a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end service-single-section -->
@stop
@section('page-specific-scripts')
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
@endsection