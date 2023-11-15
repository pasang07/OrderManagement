@extends('layouts.front-end.layouts', ['pagetitle'=> $model->title])
@section('content')

    <!-- breadcrumb-area-start -->
    <div class="breadcrumb-area pt-245 pb-245 " style="background-image:url({{asset('uploads/SEO/thumbnail/'.$image)}})">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-text text-center">
                        <h1>Blog Details</h1>
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
                                <img src="{{asset('uploads/Blog/Inner/thumbnail/'.$model->inner_image)}}" alt="" />
                            </div>
                            <div class="latest-news-text">
                                <div class="blog-meta">
                                    @if($model->author) <span>By <a href="{{route('blog-single',$model->slug)}}">{{$model->author}}</a></span> @endif
                                    <span>{{date('d M, Y', strtotime($model->created_at))}}</span>
                                    <span><a href="{{route('blog-by-category',$model->blog_category->slug)}}">{{$model->blog_category->title}}</a></span>
                                </div>
                                <h4>
                                    <a href="{{route('blog-single',$model->slug)}}">{{$model->title}}</a>
                                </h4>
                                <div>{!! $model->content !!}</div>
                            </div>
                        </div>
                        {{--<div class="row">--}}
                            {{--<div class="col-xl-6 col-lg-6 col-md-6">--}}
                                {{--<div class="blog-post-tag">--}}
                                    {{--<a href="#">APP</a>--}}
                                    {{--<a href="#">HTML</a>--}}
                                    {{--<a href="#">CSS</a>--}}
                                    {{--<a href="#">THEME</a>--}}
                                    {{--<a href="#">TEMPLATE</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-xl-6 col-lg-6 col-md-6">--}}
                                {{--<div class="blog-share-icon text-left text-md-right">--}}
                                    {{--<span>Share: </span>--}}
                                    {{--<a href="#">--}}
                                        {{--<i class="fab fa-facebook-f"></i>--}}
                                    {{--</a>--}}
                                    {{--<a href="#">--}}
                                        {{--<i class="fab fa-twitter"></i>--}}
                                    {{--</a>--}}
                                    {{--<a href="#">--}}
                                        {{--<i class="fab fa-google-plus-g"></i>--}}
                                    {{--</a>--}}
                                    {{--<a href="#">--}}
                                        {{--<i class="fab fa-instagram"></i>--}}
                                    {{--</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4">
                    <div class="sidebar-blog pl-30">
                        <div class="widget">
                            <h4 class="widget-title">Search Blogs</h4>
                            <div class="sidebar-form">
                                <form method="get" action="{{route('blog-search')}}/?search" autocomplete="off">
                                <input type="text"  name="search"  placeholder="Search" />
                                    <button type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        @if($categories->count()>0)
                        <div class="widget">
                            <h4 class="widget-title">Category</h4>
                            <div class="widget-link">
                                <ul class="sidebar-link">
                                    @foreach($categories as $category)
                                        <li>
                                            <a href="{{route('blog-by-category',$category->slug)}}">
                                                {{$category->title}} <span>({{$category->blogs->count()}})</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                        @if($recent_blogs->count()>0)
                        <div class="widget">
                            <h4 class="widget-title">Recent Posts</h4>
                            <div class="sidebar-rc-post">
                                <ul>
                                    @foreach($recent_blogs as $recent_blog)
                                    <li>
                                        <div class="rc-post-thumb">
                                            <a href="{{route('blog-single',$recent_blog->slug)}}">
                                                <img src="{{asset('uploads/Blog/thumbnail/'.$model->image)}}" width="90" />
                                            </a>
                                        </div>
                                        <div class="rc-post-content">
                                            <h4>
                                                <a href="{{route('blog-single',$recent_blog->slug)}}">{{$recent_blog->title}}</a>
                                            </h4>
                                            <div class="widget-date">{{date('d M, Y', strtotime($recent_blog->created_at))}}</div>
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