<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-8">
                <!-- [ form-element ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Banner Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title', isset($banner->title) ? $banner->title: '')}}" placeholder="Enter Banner Title" parsley-trigger="change" required>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                    <div class="row">
                                        <div class="@if(isset($banner->image))col-md-8 @else col-md-12 @endif"><div class="form-group">
                                                <label>Upload Banner Image <span class="text-danger">*</span> <label class="img-size">(Size:-1920x881)</label></label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="image" name="image" value="{{ old('image', isset($banner->image) ? $banner->image: '')}}" @if(!isset($banner->image))required @endif>
                                                    <label class="custom-file-label" for="image">Choose file...</label>
                                                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                                                </div>
                                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                            </div></div>
                                        @if(isset($banner->image))
                                             <div class="col-md-4">
                                                <div class="image-trap">
                                                    <a href="{{asset('uploads/Banner/thumbnail/'.$banner->image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class=" img-responsive">
                                                        <img class="img-thumbnail image_list"  src="{{asset('uploads/Banner/thumbnail/'.$banner->image)}}" alt="activity-user">
                                                    </a>
                                                </div>
                                            </div>
                                            @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="content">Content</label>
                                        <textarea name="content" id="editor" rows="8" class="form-control" placeholder="Enter content here.">{{ old('content', isset($banner->content) ? $banner->content: '')}}</textarea>
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
                                            <option value="active" {{ old('status', isset($banner->status) ? $banner->status : '')=='active'?'selected="selected"':''}}>Active</option>
                                            <option value="in_active" {{ old('status', isset($banner->status) ? $banner->status : '')=='in_active'?'selected="selected"':''}}>Inactive</option>
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