<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-8">
                <!-- [ form-element ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Service Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title', isset($amenity->title) ? $amenity->title: '')}}" placeholder="Enter Service Title" parsley-trigger="change" required>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                    <div class="form-group">
                                        <label for="content">Content <span class="text-danger">*</span></label>
                                        <textarea name="content" id="editor" rows="8" class="form-control" placeholder="Enter content here.">{{ old('content', isset($amenity->content) ? $amenity->content: '')}}</textarea>
                                    </div>
                                    {{--<div class="row">--}}
                                        {{--<div class="@if(isset($amenity->image))col-md-9 @else col-md-12 @endif"><div class="form-group">--}}
                                                {{--<label>Upload Service Image <label class="img-size">(Size:-769x385)</label></label>--}}
                                                {{--<div class="custom-file">--}}
                                                    {{--<input type="file" class="custom-file-input" id="image" name="image" value="{{ old('image', isset($amenity->image) ? $amenity->image: '')}}" >--}}
                                                    {{--<label class="custom-file-label" for="image">Choose file...</label>--}}
                                                    {{--<div class="invalid-feedback">Example invalid custom file feedback</div>--}}
                                                {{--</div>--}}
                                                {{--<span class="text-danger">{{ $errors->first('image') }}</span>--}}
                                            {{--</div></div>--}}
                                        {{--@if(isset($amenity->image))--}}
                                            {{--<div class="col-md-3">--}}
                                                {{--<div class="image-trap">--}}
                                                    {{--<div class="custom-control custom-checkbox select-1">--}}
                                                        {{--<input type="checkbox" class="custom-control-input" id="customCheck_imag"  name="delete_image" value="delete_image">--}}
                                                        {{--<label class="custom-control-label" for="customCheck_imag" title="Check for delete this image"></label>--}}
                                                    {{--</div>--}}
                                                    {{--<a href="{{asset('uploads/Amenity/thumbnail/'.$amenity->image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class=" img-responsive">--}}
                                                        {{--<img class="img-thumbnail image_list"  src="{{asset('uploads/Amenity/thumbnail/'.$amenity->image)}}" alt="activity-user">--}}
                                                    {{--</a>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}

                                    <div class="row">
                                        <div class="@if(isset($amenity->home_image))col-md-9 @else col-md-12 @endif"><div class="form-group">
                                                <label>Upload Small Image <span class="text-danger">*</span> <label class="img-size">(Size:-65x65)</label></label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="home_image" name="home_image" value="{{ old('home_image', isset($amenity->home_image) ? $amenity->home_image: '')}}" @if(!isset($amenity->home_image))required @endif>
                                                    <label class="custom-file-label" for="image">Choose file...</label>
                                                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                                                </div>
                                                <span class="text-danger">{{ $errors->first('home_image') }}</span>
                                            </div></div>
                                        @if(isset($amenity->home_image))
                                            <div class="col-md-3">
                                                <div class="image-trap">
                                                    <div class="custom-control custom-checkbox select-1">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck_banner"  name="delete_home_image" value="delete_home_image">
                                                        <label class="custom-control-label" for="customCheck_banner" title="Check for delete this image"></label>
                                                    </div>
                                                    <a href="{{asset('uploads/Amenity/SmallImage/thumbnail/'.$amenity->home_image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class=" img-responsive">
                                                        <img class="img-thumbnail image_list"  src="{{asset('uploads/Amenity/SmallImage/thumbnail/'.$amenity->home_image)}}" alt="No Image">
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
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
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="active" {{ old('status', isset($amenity->status) ? $amenity->status : '')=='active'?'selected="selected"':''}}>Active</option>
                                            <option value="in_active" {{ old('status', isset($amenity->status) ? $amenity->status : '')=='in_active'?'selected="selected"':''}}>Inactive</option>
                                        </select>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('status') }}</span>
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