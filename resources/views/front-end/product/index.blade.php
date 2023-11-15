@extends('layouts.front-end.layouts', ['pagetitle'=> 'Our Product'])
@section('content')
    <!-- start page-title -->
    <section class="page-title" style="background:none;height: 200px;">
        <div class="page-title-container">
            <div class="page-title-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col col-xs-12">
                            <h2>Product</h2>
                            <ol class="breadcrumbb">
                                <li><a href="{{route('home.index')}}">Home</a></li>
                                <li>Product</li>
                            </ol>
                        </div>
                    </div> <!-- end row -->
                </div> <!-- end container -->
            </div>
        </div>
        <div class="glass-effect2"></div>
    </section>
    <!-- end page-title -->


    <!-- start case-studies-section -->
    <section class="case-studies-section case-studies-pg section-padding">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <div class="case-studies-area clearfix">
                        <div class="grid">
                            <div class="img-holder">
                                <img src="{{asset('uploads/Nav/thumbnail/'.$site_data->home_image1)}}" alt>
                            </div>
                            <div class="details">
                                <div class="inner">
                                    <h5><a href="{{route('softwares')}}">Software</a></h5>
                                </div>
                            </div>
                        </div>
                        <div class="grid">
                            <div class="img-holder">
                                <img src="{{asset('uploads/Nav/thumbnail/'.$site_data->home_image2)}}" alt>
                            </div>
                            <div class="details">
                                <div class="inner">
                                    <h5><a href="{{route('websites')}}">Website</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end container -->
    </section>
    <!-- end case-studies-section -->
@stop