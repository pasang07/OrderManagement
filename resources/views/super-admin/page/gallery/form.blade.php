<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-8">

                <!-- [ form-element ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Gallery Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" class="form-control" name="page_id" id="page_id" value="{{$page_id}}" placeholder="Enter Gallery Title" parsley-trigger="change" required>
                                    @if(isset($gallery->title))
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title', isset($gallery->title) ? $gallery->title: '')}}" placeholder="Enter Gallery Title" required>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                    @endif
                                    <div class="row">
                                        <div class="@if(isset($gallery->image))col-md-8 @else col-md-12 @endif"><div class="form-group">
                                                <label>Upload Gallery Image(s) <label class="img-size">(Size:-864x546)</label></label>
                                                <div class="custom-file">
                                                    <input type="file" multiple class="custom-file-input" id="image" @if(isset($gallery->image)) name="image" @else name="image[]" @endif value="" @if(!isset($gallery->image))required @endif>
                                                    <label class="custom-file-label" for="image">Choose file...</label>
                                                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                                                </div>
                                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                            </div></div>
                                        @if(isset($gallery->image))
                                            <div class="col-md-4">
                                                <div class="image-trap">
                                                    <a href="{{asset('uploads/PageGallery/thumbnail/'.$gallery->image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class=" img-responsive">
                                                        <img class="img-thumbnail image_list"  src="{{asset('uploads/PageGallery/thumbnail/'.$gallery->image)}}" alt="activity-user">
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
                                            <option value="active" {{ old('status', isset($gallery->status) ? $gallery->status : '')=='active'?'selected="selected"':''}}>Active</option>
                                            <option value="in_active" {{ old('status', isset($gallery->status) ? $gallery->status : '')=='in_active'?'selected="selected"':''}}>Inactive</option>
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
</div >