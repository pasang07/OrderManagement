<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-8">

                <!-- [ form-element ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Albums Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    {{--<input type="hidden" value="0" name="trip_id">--}}
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title', isset($album->title) ? $album->title: '')}}" placeholder="Enter Albums Title" parsley-trigger="change" required>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                    {{--<div class="row">--}}
                                        {{--<div class="@if(isset($album->image))col-md-8 @else col-md-12 @endif"><div class="form-group">--}}
                                                {{--<label>Upload Albums Image <label class="img-size">(Size:-500x500)</label></label>--}}
                                                {{--<div class="custom-file">--}}
                                                    {{--<input type="file" class="custom-file-input" id="image" name="image" value="{{ old('image', isset($album->image) ? $album->image: '')}}" @if(!isset($album->image))required @endif>--}}
                                                    {{--<label class="custom-file-label" for="image">Choose file...</label>--}}
                                                    {{--<div class="invalid-feedback">Example invalid custom file feedback</div>--}}
                                                {{--</div>--}}
                                                {{--<span class="text-danger">{{ $errors->first('image') }}</span>--}}
                                            {{--</div></div>--}}
                                        {{--@if(isset($album->image))--}}
                                            {{--<div class="col-md-4">--}}
                                                {{--<div class="image-trap">--}}
                                                    {{--<a href="{{asset('uploads/Albums/thumbnail/'.$album->image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class=" img-responsive">--}}
                                                        {{--<img class="img-thumbnail image_list"  src="{{asset('uploads/Albums/thumbnail/'.$album->image)}}" alt="activity-user">--}}
                                                    {{--</a>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}

                                    {{--<div class="form-group">--}}
                                        {{--<label for="content">Content</label>--}}
                                        {{--<textarea name="content" id="editor" rows="8" class="form-control" placeholder="Enter content here.">{{ old('content', isset($album->content) ? $album->content: '')}}</textarea>--}}
                                    {{--</div>--}}
                                    {{--<span class="text-danger">{{ $errors->first('content') }}</span>--}}
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
                                            <option value="active" {{ old('status', isset($album->status) ? $album->status : '')=='active'?'selected="selected"':''}}>Active</option>
                                            <option value="in_active" {{ old('status', isset($album->status) ? $album->status : '')=='in_active'?'selected="selected"':''}}>Inactive</option>
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