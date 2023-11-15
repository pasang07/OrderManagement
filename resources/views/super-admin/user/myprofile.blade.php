@extends('layouts.super-admin.layouts')
@section('page-specific-css')
    <!-- Bootstrap Select Css -->
@stop
@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <!-- [ breadcrumb ] start -->
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">Profile</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">Profile</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- [ form-element ] start -->
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Profile</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6>Name:</h6>
                                                        <h6>Email Address:</h6>
                                                        @if($user->address)
                                                        <h6>Location:</h6>
                                                        @endif
                                                        @if($user->phone)
                                                        <h6>Contact:</h6>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6>{{$user->name}}</h6>
                                                        <h6>{{$user->email}}</h6>
                                                        @if($user->address)
                                                        <h6>{{$user->address}}</h6>
                                                        @endif
                                                        @if($user->phone)
                                                        <h6>{{$user->phone}}</h6>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @if(Auth::user()->role == 'agent' || Auth::user()->role == 'others')
                                            <div class="card-footer text-center">
                                                <p>Contact us to change your information.</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div >
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-specific-scripts')

@endsection
