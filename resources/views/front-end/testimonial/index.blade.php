@extends('layouts.front-end.layouts', ['pagetitle'=> 'Testimonial'])
@section('content')
    <section id="terms-page" class="bg-fixed wide-100 page-hero-section division">
        <div class="container">
            <!-- PAGE HERO TEXT -->
            <div class="row">
                <div class="col-md-10 col-xl-8 offset-md-1 offset-xl-2">
                    <div class="hero-txt text-center white-color">
                        <h3 class="h3-sm txt-color-01">Testimonial</h3>
                    </div>
                </div>
            </div>    <!-- END PAGE HERO TEXT -->
            <!-- BREADCRUMB -->
            <div id="breadcrumb">
                <div class="row">
                    <div class="col">
                        <div class="breadcrumb-nav">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home.index')}}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Testimonial</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>	<!-- END BREADCRUMB -->
        </div>	   <!-- End container -->
    </section>
    <section id="blog-page" class="bg-color-01 wide-100 blog-page-section division">
        <div class="container">
            @foreach($testimonials as $testimonial)
            <div class="row">
                <!-- SIDEBAR -->
                <aside id="sidebar" class="col-lg-2">
                    <!-- BLOG POST IMAGE -->
                    <div class="blog-post-img">
                        <img class="img-fluid" src="{{asset('uploads/Testimonial/thumbnail/'.$testimonial->image)}}" alt="blog-post-image" />
                    </div>
                </aside>
                <!-- END SIDEBAR -->
                <div class="col-lg-10">
                    <div class="single-blog-post pr-30">
                        <!-- SINGLE POST TITLE -->
                        <div class="single-post-title">
                            <!-- Post Title -->
                            <h5 class="h5-xl txt-color-01">{{$testimonial->name}}</h5>
                            <small>{{$testimonial->country}}</small>
                            <!-- Post Author -->
                        </div>

                        <!-- POST TEXT -->
                        <div class="single-post-txt">
                            <div class="txt-color-01 text-justify">
                                {!! $testimonial->content !!}
                            </div>
                        </div>
                        <!-- END POST TEXT -->
                    </div>
                </div>
            </div>
                <hr>
            @endforeach
            <!-- End row -->
        </div>	   <!-- End container -->
    </section>
@stop