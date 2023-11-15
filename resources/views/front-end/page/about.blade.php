@extends('layouts.front-end.layouts' ,['pagetitle' => 'About Us'])
@section('content')

    <!-- breadcrumb-area-start -->
    <div class="breadcrumb-area pt-245 pb-245 " style="background-image:url({{asset('uploads/SEO/thumbnail/'.$image)}})">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-text text-center">
                        <h1>About Us</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area-start -->

    <div class="build-area pt-120 pb-90 section2">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                    <div class="build-img mb-30">
                        <img src="{{asset('uploads/Page/thumbnail/'.$model->image)}}" alt="" />
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12">
                    <div class="build-wrapper mb-30">
                        <div class="build-text">
                            <h3>{{$model->title}}</h3>
                            <div class="text-justify">
                                {!! $model->content !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- map-area-start -->
    <div class="map-area">
        <div id="map" class="map">
            <iframe src="{{$site_data->map}}" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
    <!-- map-area-end -->
@stop