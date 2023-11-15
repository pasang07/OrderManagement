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
                                        <h5 class="m-b-10">Send Mail</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}"><i class="feather icon-home"></i></a></li>
                                        <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('amenityQuery.index')}}">Service Queries</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">Send Mail</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="{{route('amenityQuery.mail-send')}}" enctype="multipart/form-data" autocomplete="off" data-parsley-validate novalidate>
                        {!! csrf_field() !!}
                        <div class="main-body">
                            <div class="page-wrapper">
                                <!-- [ Main Content ] start -->
                                <div class="row">
                                    <div class="col-sm-12">

                                        <!-- [ form-element ] start -->
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5>Mail Information</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>To</label>
                                                                <input type="text" id="tags" class="tagsinput form-control" name="to[]" value="{{old('to', isset($emails) ? $emails: '')}}" placeholder="Enter E-mail" parsley-trigger="change" required>
                                                            </div>
                                                            <span class="text-danger">{{ $errors->first('to') }}</span>
                                                            <div class="form-group">
                                                                <label>Subject</label>
                                                                <input type="text" class="form-control" name="subject" id="subject" value="{{ old('subject')}}" placeholder="Enter Subject" parsley-trigger="change" required>
                                                            </div>
                                                            <span class="text-danger">{{ $errors->first('subject') }}</span>
                                                            <div class="form-group">
                                                                <label for="content">Message</label>
                                                                <textarea name="message" id="editor" rows="8" class="form-control" placeholder="Enter content here." required>{{ old('message')}}</textarea>
                                                            </div>
                                                            <span class="text-danger">{{ $errors->first('message') }}</span>
                                                            <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Send</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div >
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-specific-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('form').parsley();
        });
    </script>
@endsection
