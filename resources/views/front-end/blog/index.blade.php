@extends('layouts.front-end.layouts', ['pagetitle'=> 'Blog'])
@section('content')
    <!-- breadcrumb-area-start -->
    <div class="breadcrumb-area pt-245 pb-245 " style="background-image:url({{asset('uploads/SEO/thumbnail/'.$model->image)}})">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-text text-center">
                        <h1>Our Blog</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area-start -->
    <!-- latest-news-area-start -->
    <div class="latest-news-area pt-120 pb-120">
        <div class="container">
            <div class="row">
                @if($blogs->count()>0)
                    @foreach($blogs as $blog)
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="latest-news-wrapper mb-50">
                        <div class="latest-news-img">
                            <a href="{{route('blog-single',$blog->slug)}}">
                                <img src="{{asset('uploads/Blog/thumbnail/'.$blog->image)}}" alt="" />
                            </a>
                        </div>
                        <div class="latest-news-text">
                            <span>{{date('d M, Y', strtotime($blog->created_at))}}</span>
                            <h4>
                                <a href="{{route('blog-single',$blog->slug)}}">{{$blog->title}}</a>
                            </h4>
                            <div>
                                {!! \Illuminate\Support\Str::limit($blog->content, 200, '...') !!}
                            </div>
                            <a href="{{route('blog-single',$blog->slug)}}"> Read more
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
            {{--<div class="row mt-20">--}}
                {{--<div class="col-xl-12">--}}
                    {{--<nav class="blog-pagination" aria-label="Page navigation example">--}}
                        {{--<ul class="pagination justify-content-center">--}}
                        {{--</ul>--}}
                    {{--</nav>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>
    <!-- latest-news-area-end -->
@stop
@section('page-specific-scripts')

@endsection