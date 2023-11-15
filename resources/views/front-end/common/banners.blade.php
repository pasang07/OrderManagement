@if($video_data->video_banner)
    <div class="row-hero">
        <video class="video" poster="{{asset('uploads/VideoBanner/'.$video_data->video_banner)}}" autoplay playsinline muted loop>
            <source src="{{asset('uploads/VideoBanner/'.$video_data->video_banner)}}" type="video/mp4">
        </video>
        <div class="video-quote">
            <p style="padding: .5rem 1rem;
    color: #fff;
    background-color: rgba(0, 0, 0, 0.2);
    font-size: 2rem;
    font-weight: 600;
    text-transform: uppercase;">{{$video_data->title}}</p>
            <a href="{{route('contact-us.index')}}" class="theme-btn-s3">Get Free Consultation</a>
        </div>
    </div>
@else
<!-- Navigation slider -->
<section class="hero-slider">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @foreach($banners as $bn=>$banner)
              
            <div class="swiper-slide">
               
                    <div class="slide-inner slide-bg-image" data-background="{{asset('uploads/Banner/thumbnail/'.$banner->image)}}">
                        <div class="container">
                            <div class="row">
                                <div class="col col-xxl-10 offset-xxl-1">
                                    <div data-swiper-parallax="300" class="slide-title">
                                        {{--<h2 style="font-size:2rem;"><span>{{$banner->title}}</span></h2>--}}
                                        <h2 style="font-size:2rem;"><span>Digital Marketing</span><span>Branding on the go!</span></h2>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div data-swiper-parallax="500" class="slide-btns">
                                        <a href="{{route('contact-us.index')}}" class="theme-btn-s3">Get Free Consultation</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
               
            </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>
<!-- Navigation slider end -->
 @endif
