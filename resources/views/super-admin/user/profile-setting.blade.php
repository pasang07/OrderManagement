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
                                        <h5 class="m-b-10">Profile Setting</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">Update Profile</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="{{route('user.profile.setting', $user->id)}}" enctype="multipart/form-data" autocomplete="off" data-parsley-validate novalidate>
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
                                                    <h5>Details</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                @if(isset($user->image))
                                                                    <div class="col-md-12 text-center">
                                                                        <div class="image-trap">
                                                                            <input type="checkbox" name="" value="" class="custom-control-input" id="" title="Checked for delete this image">
                                                                            <a href="{{asset('uploads/User/thumbnail/'.$user->image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class=" img-responsive">
                                                                                <img class="img-thumbnail image_list"  src="{{asset('uploads/User/thumbnail/'.$user->image)}}" alt="no-user">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Upload User Image</label>
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="image" name="image" value="{{ old('image', isset($user->image) ? $user->image: '')}}">
                                                                            <label class="custom-file-label" for="image">Choose file...</label>
                                                                            <div class="invalid-feedback">Example invalid custom file feedback</div>
                                                                        </div>
                                                                        <span class="text-danger">{{ $errors->first('image') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Title <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name', isset($user->name) ? $user->name: '')}}" placeholder="Enter Full Name" parsley-trigger="change" required>
                                                            </div>
                                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                                            <div class="form-group col-md-6">
                                                                <label for="email">Email Address <span class="text-danger">*</span></label>
                                                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', isset($user->email) ? $user->email: '')}}" placeholder="Enter email" required readonly>
                                                            </div>
                                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                                            <div class="form-group col-md-6">
                                                                <label>Address</label>
                                                                <input type="text" class="form-control" name="address" id="address" value="{{ old('address', isset($user->address) ? $user->address: '')}}" placeholder="Enter Address">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Contact No.</label>
                                                                <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', isset($user->phone) ? $user->phone: '')}}" placeholder="Enter Your Number">
                                                            </div>
                                                        <div class="col-md-12 text-center m-t-20">
                                                            <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Submit</button>
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
