@extends('layouts.front-end.layouts', ['pagetitle'=> 'News & Notices'])
@section('content')
    <!-- breadcrumb-area-start -->
    <div class="breadcrumb-area pt-245 pb-245 " style="background-image:url({{asset('uploads/SEO/thumbnail/'.$model->image)}})">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-text text-center">
                        <h1>News & Notices</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area-start -->
    <!-- latest-news-area-start -->

    <div class="featured-area pt-110 pb-90">
        <div class="container">
            <div class="row">
                @if($newsnotices->count()>0)
                    @foreach($newsnotices as $n=>$newsnotice)
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="featured-wrapper mb-30">
                        <div class="featured-img">
                            <img src="{{asset('uploads/NewsNotice/thumbnail/'.$newsnotice->image)}}" alt=" no image" >
                        </div>
                        <div class="featured-text">
                            {{--<div class="featured-tag">--}}
                                {{--<span>{{$n + 1}}</span>--}}
                            {{--</div>--}}
                            <h4>
                                <a href="{{route('news-notice-single',$newsnotice->slug)}}">{{$newsnotice->title}}</a>
                            </h4>
                            <div>
                                {!! \Illuminate\Support\Str::limit($newsnotice->content, 170, '...') !!}
                            </div>
                            <a href="{{route('news-notice-single',$newsnotice->slug)}}"> Read more
                                <i class="fas fa-long-arrow-alt-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                    @endforeach
                @else
                    <h2>--Nothing Found--</h2>
                @endif
            </div>
        </div>
    </div>
    <!-- latest-news-area-end -->
@stop
@section('page-specific-scripts')

@endsection