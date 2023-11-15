@extends('layouts.front-end.layouts', ['pagetitle'=> $model->title])
@section('content')

    <!-- breadcrumb-area-start -->
    <div class="breadcrumb-area pt-245 pb-245 " style="background-image:url({{asset('uploads/SEO/thumbnail/'.$image)}})">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-text text-center">
                        <h1>{{$model->title}}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area-start -->
    <!-- latest-news-area-start -->
    <div class="latest-news-area pt-120 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-sm-12">
                    <div class="blog-list">
                        <div class="latest-news-wrapper blog-details mb-50">
                            <div class="latest-news-img">
                                <img src="{{asset('uploads/NewsNotice/Inner/thumbnail/'.$model->inner_image)}}" alt="no image" style="height: 300px;" />
                            </div>
                            <div class="latest-news-text">
                                <div class="blog-meta">
                                    <span>{{date('d M, Y', strtotime($model->created_at))}}</span>
                                </div>
                                <h4>
                                    <a href="{{route('news-notice-single',$model->slug)}}">{{$model->title}}</a>
                                </h4>
                                <div>{!! $model->content !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4">
                    <div class="sidebar-blog pl-30">
                        <div class="widget">
                            <h4 class="widget-title">Search News & Notices</h4>
                            <div class="sidebar-form">
                                <form method="get" action="{{route('news-notice-search')}}/?search" autocomplete="off">
                                <input type="text"  name="search"  placeholder="Search" />
                                    <button type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        @if($recent_newsnotices->count()>0)
                        <div class="widget">
                            <h4 class="widget-title">Other News & Notices</h4>
                            <div class="sidebar-rc-post">
                                <ul>
                                    @foreach($recent_newsnotices as $recent_newsnotice)
                                    <li>
                                        <div class="rc-post-thumb">
                                            <a href="{{route('news-notice-single',$recent_newsnotice->slug)}}">
                                                <img src="{{asset('uploads/NewsNotice/thumbnail/'.$model->image)}}" width="90" />
                                            </a>
                                        </div>
                                        <div class="rc-post-content">
                                            <h4>
                                                <a href="{{route('news-notice-single',$recent_newsnotice->slug)}}">{{$recent_newsnotice->title}}</a>
                                            </h4>
                                            <div class="widget-date">{{date('d M, Y', strtotime($recent_newsnotice->created_at))}}</div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- latest-news-area-end -->

@stop
@section('page-specific-scripts')

@endsection