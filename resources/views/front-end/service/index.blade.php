@extends('layouts.front-end.layouts', ['pagetitle'=> 'Services'])
@section('content')
    <!-- breadcrumb-area-start -->
    <div class="breadcrumb-area pt-245 pb-245 " style="background-image:url({{asset('uploads/SEO/thumbnail/'.$model->image)}})">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-text text-center">
                        <h1>Our Services</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area-start -->

    <!-- services-area-start -->
    <div class="services-area pt-115 pb-60 gray-bg">
        <div class="container">
            <div class="section-title section3-title text-center mb-50">
                <h1>{{$site_data->home_service_title}}</h1>
                @if($site_data->home_service_content)
                    <p>{{$site_data->home_service_content}}</p>
                @endif
            </div>
            <div class="row">
                @foreach($services as $service)
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="services-wrapper text-center mb-30">
                        <div class="services-img">
                            <img src="{{asset('uploads/Amenity/SmallImage/thumbnail/'.$service->home_image)}}" alt="no image">
                        </div>
                        <div class="services-text">
                            <a href=""><h4>{{$service->title}}</h4></a>
                            {!! $service->content !!}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- services-area-end -->
    <div class="experience-area yellow-bg pt-50 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-9 col-md-8">
                    <div class="experience-text mb-20">
                        <h2>Needs experience business consultant?</h2>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-3 col-md-4">
                    <div class="experience-button text-md-right mb-20">
                        <a class="btn" href="{{route('contact-us.index')}}">contact us <i class="fas fa-long-arrow-alt-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop