@extends('layouts.front-end.layouts')
@section('content')

    <div class="breadcrumbs">
        <div class="wrap">
            <div class="wrap_float">
                <a href="{{route('home.index')}}">Home</a>
                <span class="separator">/</span>
                <a href="{{route('albums')}}">Albums</a>
                <span class="separator">/</span>
                <a href="#" class="current">Gallery</a>
            </div>
        </div>
    </div>
    <div class="image_bg--single" style="background-image: url(img/header3.jpg);"></div>
    <div class="gallery_page">
        <div class="wrap">
            <div class="wrap_float">
                <div class="title">
                    {{$images->title}}
                </div>
                <div class="section_content lightgallery" id="lightgallery">
                    @foreach($images->gallery as $pic)
                        <a class="item" href="{{asset('uploads/Gallery/thumbnail/'.$pic->image)}}">
                            <div class="sq_parent">
                                <div class="sq_wrap">
                                    <div class="sq_content">
                                        <img src="{{asset('uploads/Gallery/thumbnail/'.$pic->image)}}" alt="">
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop
@section('page-specific-scripts')

@endsection