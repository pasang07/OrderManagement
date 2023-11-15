@extends('layouts.front-end.layouts')
@section('content')

    <div class="breadcrumbs">
        <div class="wrap">
            <div class="wrap_float">
                <a href="{{route('home.index')}}">Home</a>
                <span class="separator">/</span>
                <a href="{{route('team.index')}}">Our Team</a>
                <span class="separator">/</span>
                <a href="#" class="current">{{$team->name}}</a>
            </div>
        </div>
    </div>
    {{--<div class="image_bg--single" style="background-image: url(img/vput12.jpg);"></div>--}}
    <div class="page_content single-page tour-single dark">
        <div class="content-head">
            <div class="wrap">
                <div class="wrap_float">
                    <div class="main">
                        <div class="section-top single-row">
                            <div class="single-left">
                                <div class="title">
                                    {{$team->name}}
                                </div>
                                <div class="sub-title">{{$team->designation}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="wrap">
                <div class="wrap_float">
                    <div class="single-left">
                        <div class="description">
                            {!! $team->description !!}
                        </div>
                    </div>
                    <div class="single-right">
                        <div class="map-iframe">
                            <img src="{{asset('uploads/Team/thumbnail/'.$team->image)}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop