@extends('layouts.front-end.layouts', ['pagetitle'=> 'Contact Us'])
@section('content')
    <!-- breadcrumb-area-start -->
    <div class="breadcrumb-area pt-245 pb-245 " style="background-image:url({{asset('uploads/SEO/thumbnail/'.$model->image)}})">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-text text-center">
                        <h1>Contact Us</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area-start -->

    <!-- contact area start -->
    <div class="contact-area gray-bg pt-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="contact-info text-center mb-30">
                        <i class="fa fa-map-marker-alt"></i>
                        <h5>Location</h5>
                        <span>
                            {{$site_data->address}}
                            @if($site_data->open_time) <br>{{$site_data->open_time}} @endif
                        </span>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="contact-info text-center mb-30">
                        <i class="fas fa-headphones"></i>
                        <h5>support</h5>
                        <span>
                           @if($site_data->tel_no)<a href="tel:{{$site_data->tel_no}}">{{$site_data->tel_no}}</a> @endif
                           @if($site_data->mobile_no)<br /><a href="tel:{{$site_data->mobile_no}}">{{$site_data->mobile_no}}</a> @endif
                            <br>
                               @if($site_data->email)<a href="mailto:{{$site_data->email}}">{{$site_data->email}}</a> @endif
                               @if($site_data->email_2)<br /><a href="mailto:{{$site_data->email_2}}">{{$site_data->email_2}}</a> @endif

                        </span>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="contact-info text-center mb-30">
                        <i class="fas fa-share-alt"></i>
                        <h5>Follow Us</h5>
                        <div class="contact-social">
                            @if($site_data->facebook)
                                <a href="{{$site_data->facebook}}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            @endif
                            @if($site_data->twitter)
                                <a href="{{$site_data->twitter}}" target="_blank" ><i class="fab fa-twitter"></i></a>
                            @endif
                            @if($site_data->instagram)
                                <a href="{{$site_data->instagram}}" target="_blank"><i class="fab fa-instagram"></i></a>
                            @endif
                            @if($site_data->youtube)
                                <a href="{{$site_data->youtube}}" target="_blank" ><i class="fab fa-youtube"></i> </a>
                            @endif
                            @if($site_data->linkedin)
                                <a href="{{$site_data->linkedin}}" target="_blank" ><i class="fab fa-linkedin"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="contact-bg white-bg mt-60"> -->
            <div class="contact-bg mt-60">
                <div class="section-title section3-title title-contact text-center mb-50">
                    <h1>{{$site_data->home_product_title}}</h1>
                    <p>{{$site_data->home_product_small_title}}</p>
                </div>
                @if(session()->has('contact-messages'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{ session()->get('contact-messages') }}
                    </div>
                @endif
                <form class="contact-form" action="{{route('contact-us.mail')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-lg-6 col-md-6 mb-20">
                            <input type="text" name="name"  placeholder="Your Name*">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                        <div class="col-lg-6 col-md-6 mb-20">
                            <input type="text" name="contact_email" placeholder="Your Email*">
                            <span class="text-danger">{{ $errors->first('contact_email') }}</span>
                        </div>
                        <div class="col-lg-6 col-md-6 mb-20">
                            <input type="text" name="address"  placeholder="Your Address*" >
                            <span class="text-danger">{{ $errors->first('address') }}</span>
                        </div>
                        <div class="col-lg-6 col-md-6 mb-20">
                            <input type="text" name="phone"  placeholder="Your Phone*" >
                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                        </div>

                        <div class="col-lg-12 col-md-12 mb-20">
                            <input type="text" name="subject" placeholder="Subject*" >
                            <span class="text-danger">{{ $errors->first('subject') }}</span>
                        </div>
                        <div class="col-lg-12 col-md-12 mb-20">
                            <textarea name="message" cols="30" rows="10" placeholder="Your Queries*" ></textarea>
                            <span class="text-danger">{{ $errors->first('message') }}</span>
                            <div class="text-center mt-20">
                                <button class="btn">send question</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- contact area end -->

    <!-- map-area-start -->
    <div class="map-area">
        <div id="map" class="map">
            <iframe src="{{$site_data->map}}" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
    <!-- map-area-end -->
@stop