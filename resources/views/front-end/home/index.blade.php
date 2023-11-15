@extends('layouts.front-end.layouts')
@section('content')
    <!-- slider-area-start -->
    <div class="slider-area">
        <div class="slider-wrapper height-800 d-flex align-items-center" style="background-image:url({{asset('uploads/Nav/thumbnail/'.$site_data->home_banner)}})">
            <div class="container">
                <div class="slider-content large-text text-center">
                    <h1 data-animation="fadeInUp" data-delay=".5s" >{{$site_data->banner_title}}</h1>
                    @if($site_data->banner_content) <p>{{$site_data->banner_content}}</p> @endif
                    <div class="slider-button">
                        <a class="btn white-btn scroll-down" href="#" data-animation="fadeInLeft" data-delay="1.5s">
                           Read More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider-area-end -->

    <!-- build-area-start -->
    <div class="build-area pt-120 pb-90 section2">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                    <div class="build-img mb-30">
                        <img src="{{asset('uploads/Page/thumbnail/'.$about->image)}}" alt="No Image" />
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12">
                    <div class="build-wrapper mb-30">
                        <div class="build-text">
                            <h3>{{$about->title}}</h3>
                            <div class="text-justify">
                                {!! \Illuminate\Support\Str::limit($about->content, 535) !!}
                            </div>
                            @if((strlen($about->content))>540)
                                <a href="{{route('page', $about->slug)}}">Read More <i class="fas fa-long-arrow-alt-right"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- build-area-end -->

    <!-- features-area-start -->
    @if($features->count()>0)
    <div class="featureds-area">
        <div class="featureds-inner">
            @foreach($features as $f=>$feature)
            <div class="featureds-item">
                <div class="featureds-wrapper text-center ">
                    <div class="featureds-img">
                        <img src="{{asset('uploads/Feature/thumbnail/'.$feature->image)}}" alt="No Image" />
                    </div>
                    <div class="featureds-text">
                        <h4>{{$feature->title}}</h4>
                        {!! $feature->content  !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    <!-- features-area-end -->

    <!-- services-area-start -->
    @if($services->count()>0)
    <div class="services-area pt-110 pb-90 gray-bg">
        <div class="container">
            <div class="section-title text-center mb-50">
                <h1>{{$site_data->home_service_title}}</h1>
               @if($site_data->home_service_content) <p>{{$site_data->home_service_content}}</p> @endif
            </div>
            <div class="row">
                @foreach($services as $service)
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="services-wrapper text-center mb-30">
                        <div class="services-img">
                            <img src="{{asset('uploads/Amenity/SmallImage/thumbnail/'.$service->home_image)}}" alt="No Image" />
                        </div>
                        <div class="services-text">
                            <h4>{{$service->title}}</h4>
                            <div>
                                {!! $service->content !!}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    <!-- services-area-end -->
    <div class="request-area pt-250 pb-70" style="background-image:url({{asset('uploads/Nav/thumbnail/'.$site_data->home_image1)}})">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-8">
                    <div class="request-wrapper">
                        <div class="request-text">
                            <h1>{{$site_data->home_product_title}}</h1>
                            <p>{{$site_data->home_product_small_title}}</p>
                        </div>
                        <form id="request-form" action="{{route('contact-us.mail')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-xl-6 mb-30">
                                    <input type="text" name="name"  placeholder="Your Name*">
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                </div>
                                <div class="col-xl-6 mb-30">
                                    <input type="text" name="contact_email" placeholder="Your Email*">
                                    <span class="text-danger">{{ $errors->first('contact_email') }}</span>
                                </div>
                                <div class="col-xl-6 mb-30">
                                    <input type="text" name="address"  placeholder="Your Address*" >
                                    <span class="text-danger">{{ $errors->first('address') }}</span>
                                </div>
                                <div class="col-xl-6 mb-30">
                                    <input type="text" name="phone"  placeholder="Your Phone*" >
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                </div>

                                <div class="col-xl-12 mb-30">
                                    <input type="text" name="subject" placeholder="Subject*" >
                                    <span class="text-danger">{{ $errors->first('subject') }}</span>
                                </div>
                                <div class="col-xl-12 mb-30">
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
        </div>
    </div>

    <!-- counter-area-start -->
    <div class="counter3-area pt-110 pb-85">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="counter-wrapper mb-30">
                        <div class="counter-text counter3-text text-center">
                            <h1 class="counter">{{$site_data->value1}}</h1>
                            <span>{{$site_data->title1}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="counter-wrapper mb-30">
                        <div class="counter-text counter3-text text-center">
                            <h1 class="counter">{{$site_data->value2}}</h1>
                            <span>{{$site_data->title2}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="counter-wrapper mb-30">
                        <div class="counter-text counter3-text text-center">
                            <h1 class="counter">{{$site_data->value3}}</h1>
                            <span>{{$site_data->title3}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="counter-wrapper">
                        <div class="counter-text counter3-text text-center">
                            <h1 class="counter">{{$site_data->value4}}</h1>
                            <span>{{$site_data->title4}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- counter-area-end -->

    <!-- meet-area-start -->

    {{--<div class="experience-area yellow-bg pt-50 pb-30">--}}
        {{--<div class="container">--}}
            {{--<div class="row">--}}
                {{--<div class="col-xl-8 col-lg-9 col-md-8">--}}
                    {{--<div class="experience-text mb-20">--}}
                        {{--<h2>Needs experience business consultant?</h2>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-xl-4 col-lg-3 col-md-4">--}}
                    {{--<div class="experience-button text-md-right mb-20">--}}
                        {{--<a class="btn" href="#">contact us <i class="fas fa-long-arrow-alt-right"></i></a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    <div class="meet-area pt-110 pb-90" style="background-image:url({{asset('uploads/Nav/thumbnail/'.$site_data->home_image2)}})">
        <div class="container">
            <div class="row">
                <div class="offset-xl-4 col-xl-8 col-lg-10 offset-lg-2">
                    <div class="meet-wrapper">
                        <div class="meet-text">
                            <h1>{{$site_data->home_quote_title}}</h1>
                            <p>{{$site_data->home_quote_content}}</p>
                            <a href="#">contact us <i class="fas fa-long-arrow-alt-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- meet-area-end -->

    @if($blogs->count()>0)
    <!-- blog-area-start -->
    <div class="news-area pt-110 pb-90">
        <div class="container">
            <div class="section-title text-center mb-50">
                <h1>Our Blog</h1>
                {{--<p> Nullam varius turpis et commodo pharetra est eros bibendum elitnec luctus magna felis sollicitudin mauris. Integer mauris eu nibh euismod graviduis tellus etvulp utate vehicula.</p>--}}
            </div>
            <div class="row">
                @foreach($blogs as $blog)
                <div class="col-lg-4 col-lg-4 col-md-6 col-sm1-2">
                    <div class="news-wrapper mb-30">
                        <div class="news-img">
                            <a href="{{route('blog-single',$blog->slug)}}"><img src="{{asset('uploads/Blog/thumbnail/'.$blog->image)}}" alt="No Image" /></a>
                            <div class="news-info">
                                <a class="btn"  href="{{route('blog-by-category',$blog->blog_category->slug)}}">{{$blog->blog_category->title}}</a>
                                <span>{{date('d M, Y', strtotime($blog->created_at))}}</span>
                            </div>
                        </div>
                        <div class="news-text">
                            <div class="news-meta">
                                @if($blog->author) <span>Post By <a href="{{route('blog-single',$blog->slug)}}">{{$blog->author}}</a></span> @endif
                                {{--<span>Comments (03)</span>--}}
                            </div>
                            <h4><a href="{{route('blog-single',$blog->slug)}}">{{$blog->title}}</a></h4>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- blog-area-end -->
    @endif


    <!-- map-area-start -->
    <div class="map-area">
        <div id="map" class="map">
            <iframe src="{{$site_data->map}}" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
    <!-- map-area-end -->
@stop
@section('page-specific-scripts')

@endsection