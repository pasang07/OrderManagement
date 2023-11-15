@extends('layouts.front-end.layouts', ['pagetitle'=> 'Software'])
@section('content')
    <!-- start page-title -->
    <section class="page-title" style="background:none;height: 200px;">
        <div class="page-title-container">
            <div class="page-title-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col col-xs-12">
                            <h2 style="font-size:2rem;">Software</h2>
                            <ol class="breadcrumbb">
                                <li><a href="{{route('home.index')}}">Home</a></li>
                                <li><a href="{{route('all.product')}}">Product</a></li>
                                <li>Software</li>
                            </ol>
                        </div>
                    </div> <!-- end row -->
                </div> <!-- end container -->
            </div>
        </div>
        <div class="glass-effect2"></div>
    </section>
    <!-- end page-title -->


    <!-- start case-studies-section -->
    <section class="case-studies-section case-studies-pg section-padding">
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <div class="case-studies-area clearfix">
                        @foreach($softwares as $software)
                            <div class="grid">
                            <div class="img-holder">
                                <img src="{{asset('uploads/Software/thumbnail/'.$software->image)}}" alt>
                            </div>
                            <div class="details">
                                <div class="inner">
                                    <img src="{{asset('uploads/SoftwareLogo/thumbnail/'.$software->logo_image)}}" alt>
                                    <h5><a href="{{route('software-single',$software->slug)}}">{{$software->title}}</a></h5>
                                    <p class="cat"><a href="{{route('software-single',$software->slug)}}">{{$software->short_inc}}</a></p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col col-xs-12" style="float: right;margin-top: 30px;">
                <ul>
                    {!! $softwares->render() !!}
                </ul>
            </div>
        </div> <!-- end container -->
    </section>
    <!-- end case-studies-section -->
@stop