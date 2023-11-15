@extends('layouts.super-admin.layouts')
@section('content')
    <section class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <!-- [ breadcrumb ] start -->
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10"></h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('contact.index')}}">Contact Us</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">{{$contact->subject}}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ breadcrumb ] end -->
                        <div class="main-body">
                            <div class="page-wrapper">
                                <!-- [ Main Content ] start -->
                                <div class="row">
                                    <!-- [ sample-page ] start -->
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{$contact->subject}}</h5>
                                            </div>
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            {!! $contact->content !!}
                                                            <br>
                                                            ---------------------------------------------------------------------
                                                            <br>
                                                            <h6>Sent From:</h6>
                                                            <div class="mt-10">
                                                                <p>
                                                                    {{$contact->name}} <br>
                                                                    {{$contact->address}}<br>
                                                                    {{$contact->email}}<br>
                                                                    {{$contact->phone}}
                                                                </p>
                                                            </div>
                                                            <a href="{{route('contact.index')}}" type="button" class="btn btn-warning" >Return Back</a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- [ sample-page ] end -->
                                </div>
                                <!-- [ Main Content ] end -->
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('page-specific-scripts')
@endsection