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
                                        <h5 class="m-b-10">Setting</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">Setting</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="{{route('site-settings.update',$siteSetting->id)}}" enctype="multipart/form-data" autocomplete="off" data-parsley-validate novalidate>
                        {!! csrf_field() !!}
                        <div class="main-body">
                            <div class="page-wrapper">
                                <!-- [ Main Content ] start -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <!-- [ form-element ] start -->
                                        <div class="form-group">
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active text-uppercase" id="system-details-tab" data-toggle="tab" href="#system-details" role="tab" aria-controls="system-details" aria-selected="true">System Settings</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link text-uppercase" id="bank-setting-tab" data-toggle="tab" href="#bank-setting" role="tab" aria-controls="bank-setting" aria-selected="false">Bank Settings</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="system-details" role="tabpanel" aria-labelledby="system-details-tab">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            {{--<div class="form-group">--}}
                                                                {{--<label>Software Name <span class="text-danger">*</span></label>--}}
                                                                {{--<input type="text" class="form-control" name="title" id="title" value="{{ old('title', isset($siteSetting->title) ? $siteSetting->title: '')}}" placeholder="Enter Site Title" required>--}}
                                                            {{--</div>--}}
                                                            {{--<span class="text-danger">{{ $errors->first('title') }}</span>--}}
                                                            <div class="row">
                                                                <div class="form-group col-md-6">
                                                                    <label>E-mail <span class="text-danger">*</span></label>
                                                                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email', isset($siteSetting->email) ? $siteSetting->email: '')}}" placeholder="Enter Email Address" required>
                                                                </div>
                                                                <span class="text-danger">{{ $errors->first('email') }}</span>

                                                                <div class="form-group col-md-6">
                                                                    <label>Second E-mail</label>
                                                                    <input type="email" class="form-control" name="email_2" id="email_2" value="{{ old('email_2', isset($siteSetting->email_2) ? $siteSetting->email_2: '')}}" placeholder="Enter Email Address">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label>Third E-mail</label>
                                                                    <input type="email" class="form-control" name="email_3" id="email_3" value="{{ old('email_3', isset($siteSetting->email_3) ? $siteSetting->email_3: '')}}" placeholder="Enter Email Address">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label>Fourth E-mail</label>
                                                                    <input type="email" class="form-control" name="email_4" id="email_4" value="{{ old('email_4', isset($siteSetting->email_4) ? $siteSetting->email_4: '')}}" placeholder="Enter Email Address">
                                                                </div>
                                                                <div class="form-group  col-md-6">
                                                                    <label>Address </label>
                                                                    <input type="text" class="form-control" name="address" id="address" value="{{ old('address', isset($siteSetting->address) ? $siteSetting->address: '')}}" placeholder="Enter Address">
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="@if(isset($siteSetting->logo_image))col-md-9 @else col-md-12 @endif"><div class="form-group">
                                                                        <label>Upload Logo <label class="img-size">(Size:-664x286)</label></label>
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="logo_image" name="logo_image" value="{{ old('logo_image', isset($siteSetting->logo_image) ? $siteSetting->logo_image: '')}}">
                                                                            <label class="custom-file-label" for="logo_image">Choose file...</label>
                                                                            <div class="invalid-feedback">Example invalid custom file feedback</div>
                                                                        </div>
                                                                        <span class="text-danger">{{ $errors->first('logo_image') }}</span>
                                                                    </div></div>
                                                                @if(isset($siteSetting->logo_image))
                                                                    <div class="col-md-3">
                                                                        <div class="image-trap">
                                                                            <div class="custom-control custom-checkbox select-1">
                                                                                <input type="checkbox" class="custom-control-input" id="customCheck_logo_image"  name="delete_logo_image" value="delete_logo_image">
                                                                                <label class="custom-control-label" for="customCheck_logo_image" title="Check for delete this image"></label>
                                                                            </div>
                                                                            <a href="{{asset('uploads/Nav/thumbnail/'.$siteSetting->logo_image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class=" img-responsive">
                                                                                <img class="img-thumbnail image_list"  src="{{asset('uploads/Nav/thumbnail/'.$siteSetting->logo_image)}}" alt="No Image">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="bank-setting" role="tabpanel" aria-labelledby="bank-setting-tab">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                           <div class="row">
                                                               <div class="form-group">
                                                                   <label for="content">Bank Description</label>
                                                                   <textarea name="bank_details" id="editor" rows="8" class="form-control" placeholder="Enter Bank Details here.">{{ old('bank_details', isset($site_data->bank_details) ? $site_data->bank_details: '')}}</textarea>
                                                               </div>
                                                           </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Update</button>
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
