<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">

                <!-- [ form-element ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Admin Information</h5>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Full Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', isset($user->name) ? $user->name: '')}}" placeholder="Enter Your Full Name" parsley-trigger="change" required>
                                        </div>
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="address" id="address" value="{{ old('address', isset($user->address) ? $user->address: '')}}" placeholder="Enter Address">
                                    </div>

                                    <div class="form-group">
                                        <label>Contact No.</label>
                                        <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', isset($user->phone) ? $user->phone: '')}}" placeholder="Enter Your Number">
                                    </div>
                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <select class="form-control" id="gender" name="gender" required>
                                            <option value="male" {{ old('gender', isset($user->gender) ? $user->gender : '')=='male'?'selected="selected"':''}}>Male</option>
                                            <option value="female" {{ old('gender', isset($user->gender) ? $user->gender : '')=='female'?'selected="selected"':''}}>Female</option>
                                            <option value="others" {{ old('gender', isset($user->gender) ? $user->gender : '')=='others'?'selected="selected"':''}}>Others</option>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="@if(isset($user->image))col-md-8 @else col-md-12 @endif">
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
                                        @if(isset($user->image))
                                            <div class="col-md-4">
                                                <div class="image-trap">
                                                    <input type="checkbox" name="" value="" class="custom-control-input" id="" title="Checked for delete this image">
                                                    <a href="{{asset('uploads/User/thumbnail/'.$user->image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class=" img-responsive">
                                                        <img class="img-thumbnail image_list"  src="{{asset('uploads/User/thumbnail/'.$user->image)}}" alt="no-user">
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email Address <span class="text-danger">*</span>
                                            <br><small class="text-primary">email should be unique. Once created email, it can not be changed.</small>
                                        </label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', isset($user->email) ? $user->email: '')}}" {{isset($user->email) ? 'readonly="readonly"': ''}} aria-describedby="emailHelp" placeholder="Enter email" required>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('email') }}</span>

                                    {{--<div class="form-group">--}}
                                    {{--<label for="username">Username <span class="text-danger">*</span></label>--}}
                                    {{--<input type="text" class="form-control" id="username" name="username" value="{{ old('username', isset($user->username) ? $user->username: '')}}" {{isset($user->username) ? 'readonly="readonly"': ''}} placeholder="Username" required>--}}
                                    {{--</div>--}}
                                    {{--<span class="text-danger">{{ $errors->first('username') }}</span>--}}
                                    <div class="form-group">
                                        <label for="password">Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password" name="password" value="{{isset($user->password) ? $user->password: ''}}"  placeholder="Password" required>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                    <div class="form-group">
                                        <label for="password_confirmation">Re-Type Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="{{isset($user->password) ? $user->password: ''}}" placeholder="Password" required>
                                    </div>
                                    <!--<input type="hidden" value="admin" name="role">-->
                                    
                                    
                                        <div class="form-group">
                                            <label for="status">Role</label>
                                            <select class="form-control" id="role" name="role" required>
                                                <option value="admin" {{ old('role', isset($user->role) ? $user->role : '')=='admin'?'selected="selected"':''}}>Admin</option>
                                                <option value="demo" {{ old('role', isset($user->role) ? $user->role : '')=='demo'?'selected="selected"':''}}>Demo User</option>
                                            </select>
                                        </div>
                                        <span class="text-danger">{{ $errors->first('role') }}</span>
                                        
                                 
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="active" {{ old('status', isset($user->status) ? $user->status : '')=='active'?'selected="selected"':''}}>Active</option>
                                                <option value="in_active" {{ old('status', isset($user->status) ? $user->status : '')=='in_active'?'selected="selected"':''}}>Inactive</option>
                                            </select>
                                        </div>
                                        <span class="text-danger">{{ $errors->first('status') }}</span>

                                </div>
                                <div class="col-md-12 text-right m-t-20">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>