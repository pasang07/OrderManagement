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
                                        <h5 class="m-b-10">Edit Agent</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">Refer / Request Customer</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="{{route('refer-customer.update',$referCustomer->id)}}" enctype="multipart/form-data" autocomplete="off" data-parsley-validate>
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
                                                    <h5>Customer Request Form</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="form-group col-md-6">
                                                                    <label>Name <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name', isset($referCustomer->name) ? $referCustomer->name: '')}}" placeholder="Enter Name" parsley-trigger="change" required>
                                                                </div>
                                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                                                <div class="form-group col-md-6">
                                                                    <label>Email <span class="text-danger">*</span></label>
                                                                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email', isset($referCustomer->email) ? $referCustomer->email: '')}}" placeholder="Enter Email" parsley-trigger="change" required>
                                                                </div>
                                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                                                <div class="form-group col-md-6">
                                                                    <label>Address <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" name="address" id="address" value="{{ old('address', isset($referCustomer->address) ? $referCustomer->address: '')}}" placeholder="Enter Address" parsley-trigger="change" required>
                                                                </div>
                                                                <span class="text-danger">{{ $errors->first('address') }}</span>
                                                                <div class="form-group col-md-6">
                                                                    <label>Phone <span class="text-danger">*</span></label>
                                                                    <input type="tel" class="form-control" name="phone" id="phone" value="{{ old('phone', isset($referCustomer->phone) ? $referCustomer->phone: '')}}" placeholder="Enter Phone" parsley-trigger="change" required>
                                                                </div>
                                                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                                                <div class="col-md-12 m-t-20">
                                                                    <button type="submit" class="btn btn-success" id="btn-submit"><i class="fas fa-paper-plane"></i> Update</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
