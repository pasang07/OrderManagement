@extends('layouts.front-end.layouts',['pagetitle' => 'Our Team'])
@section('content')
    <section class="breadcrumb-outer text-center" style="background: url('{{asset('uploads/SEO/thumbnail/'.$model->image)}}') no-repeat !important;background-size: cover !important;">
        <div class="container">
            <div class="breadcrumb-content">
                <h2 class="white">Our Team</h2>
                <nav aria-label="breadcrumb">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Our Team</li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="overlay"></div>
    </section>
    <section class="tour-agent">
        <div class="container">
            <div class="agent-main">
                <div class="row">
                    @foreach($teams as $team)
                        <div class="col-md-3">
                        <div class="agent-list">
                            <div class="agent-image">
                                <img src="{{asset('uploads/Team/thumbnail/'.$team->image)}}" alt="No Image">
                                <div class="agent-content">
                                    <h3 class="white mar-bottom-5">{{$team->name}}</h3>
                                    <p class="white mar-0">{{$team->designation}}</p>
                                    <a href="{{route('team-profile',$team->slug)}}" class="white">View Details</a>
                                </div>
                            </div>
                            <div class="agent-social">
                                <ul class="social-links">
                                    @if($team->phone)<li><a href="tel:{{$team->phone}}" target="_blank"><i class="fa fa-phone" aria-hidden="true"></i></a></li>@endif
                                    @if($team->email)<li><a href="mailto:{{$team->email}}" target="_blank"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>@endif
                                    @if($team->facebook)<li><a href="{{$team->facebook}}" target="_blank"><i class="fab fa-facebook" aria-hidden="true"></i></a></li>@endif
                                    @if($team->twitter)<li><a href="{{$team->twitter}}" target="_blank"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>@endif
                                    @if($team->instagram)<li><a href="{{$team->instagram}}" target="_blank"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>@endif
                                    @if($team->twitter)<li><a href="{{$team->twitter}}" target="_blank"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>@endif
                                    @if($team->skype)<li><a href="https://msng.link/o/?{{$team->skype}}.com=sk" target="_blank" aria-hidden="true"><i class="fab fa-skype"></i></a></li>@endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@stop