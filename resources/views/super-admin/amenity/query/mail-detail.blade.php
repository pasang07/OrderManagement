@extends('layouts.super-admin.layouts')
@section('content')
    <?php
    $serviceTitle = \App\Models\Model\SuperAdmin\Amenity\Amenity::where('id',$amenityQuery->service_id)->first()->title;
    ?>
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
                                        <li class="breadcrumb-item"><a href="{{route('amenityQuery.index')}}">Service Queries</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">{{$amenityQuery->subject}}</a></li>
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
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>{{$serviceTitle}}</h5>
                                            </div>
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h6>
                                                                Requesting For:
                                                                @if($amenityQuery->quote == "yes_quote") Quote, @endif
                                                                @if($amenityQuery->demo == "yes_demo") Demo, @endif
                                                                @if($amenityQuery->info == "yes_info") Info @endif
                                                            </h6>
                                                            ---------------------------------------------------------------------
                                                            <br>
                                                            <h6>Sent From:</h6>
                                                            <div class="mt-10">
                                                                <p>
                                                                    {{$amenityQuery->name}} <br>
                                                                    {{$amenityQuery->email}}<br>
                                                                    {{$amenityQuery->phone}}
                                                                </p>
                                                            </div>
                                                            <a href="{{route('amenityQuery.index')}}" type="button" class="btn btn-warning" >Return Back</a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <form method="post" action="{{route('amenityQuery.mail-send')}}" enctype="multipart/form-data" autocomplete="off" data-parsley-validate novalidate>
                                            {!! csrf_field() !!}
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5>Reply to this person</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>To</label>
                                                                <input type="email" class="form-control" name="to[]" value="{{$amenityQuery->email}}" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Subject <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" name="subject" id="subject" placeholder="Enter Subject" value="RE: {{$serviceTitle}}" parsley-trigger="change" required>
                                                            </div>
                                                            <span class="text-danger">{{ $errors->first('subject') }}</span>
                                                            <div class="form-group">
                                                                <label for="content">Message <span class="text-danger">*</span></label>
                                                                <textarea name="message" id="editor" rows="8" class="form-control" placeholder="Enter content here." required></textarea>
                                                            </div>
                                                            <span class="text-danger">{{ $errors->first('message') }}</span>
                                                            <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Send</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

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