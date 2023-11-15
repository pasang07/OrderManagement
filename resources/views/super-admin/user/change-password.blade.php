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
                                        <h5 class="m-b-10">Change Password</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}"><i class="feather icon-home"></i></a></li>
                                        <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">Change Password</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="{{route('user.change-password')}}" enctype="multipart/form-data" autocomplete="off" data-parsley-validate novalidate>
                        {!! csrf_field() !!}
                        <div class="main-body">
                            <div class="page-wrapper">
                                <!-- [ Main Content ] start -->
                                <div class="row">
                                    <div class="col-sm-8">
                                        <!-- [ form-element ] start -->
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5>Details</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Old Password</label>
                                                                <input type="password" class="form-control" name="oldpassword" id="oldpassword" value="" placeholder="Enter Old Password" parsley-trigger="change" required>
                                                            </div>
                                                            <span class="text-danger">{{ $errors->first('oldpassword') }}</span>
                                                            <div class="form-group">
                                                                <label>New Password</label>
                                                                <input type="password" class="form-control" name="password" id="pwfield" value="" placeholder="Enter New Password"  required>
                                                            </div>
                                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                                            <div class="form-group">
                                                                <label>Confirmed Password</label>
                                                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" value="" placeholder="Enter Confirmed Password" data-parsley-equalto="#pwfield" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <!-- [ form-element ] start -->
                                        <div class="col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5>Action</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Update</button>
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
