<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-8">
                <!-- [ form-element ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Page Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title', isset($page->title) ? $page->title: '')}}" placeholder="Enter Page Title" parsley-trigger="change" required>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                    {{--<div class="form-group">--}}
                                        {{--<label>Small Header Title</label>--}}
                                        {{--<input type="text" class="form-control" name="small_header" id="small_header" value="{{ old('small_header', isset($page->small_header) ? $page->small_header: '')}}" placeholder="Enter Small Title">--}}
                                    {{--</div>--}}
                                    <div class="row">
                                        <div class="@if(isset($page->image))col-md-8 @else col-md-12 @endif"><div class="form-group">
                                                <label>Upload Page Image <label class="img-size">(Size:-800x437)</label></label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="image" name="image" value="{{ old('image', isset($page->image) ? $page->image: '')}}">
                                                    <label class="custom-file-label" for="image">Choose file...</label>
                                                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                                                </div>
                                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                            </div></div>
                                        @if(isset($page->image))
                                            <div class="col-md-4">
                                                <div class="image-trap">
                                                    <div class="custom-control custom-checkbox select-1">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck"  name="delete_image" value="delete_image">
                                                        <label class="custom-control-label" for="customCheck" title="Check for delete this image"></label>
                                                    </div>
                                                    <a href="{{asset('uploads/Page/thumbnail/'.$page->image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class=" img-responsive">
                                                        <img class="img-thumbnail image_list"  src="{{asset('uploads/Page/thumbnail/'.$page->image)}}" alt="activity-user">
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="content">Content</label>
                                        <textarea name="content" id="editor" rows="8" class="form-control" placeholder="Enter content here." required>{{ old('content', isset($page->content) ? $page->content: '')}}</textarea>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('content') }}</span>
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
                            <h5>SEO</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Seo Title</label>
                                        <input type="text" class="form-control" name="seo_title" id="seo_title" value="{{ old('seo_title', isset($page->seo_title) ? $page->seo_title: '')}}" placeholder="Enter SEO Title" parsley-trigger="change">
                                    </div>
                                    <div class="form-group">
                                        <label>Seo Keywords</label>
                                        <input type="text" id="tags" class="tagsinput form-control" name="seo_keywords" value="{{ old('seo_keywords', isset($page->seo_keywords) ? $page->seo_keywords: '')}}" placeholder="Enter SEO Keywords" parsley-trigger="change">
                                    </div>
                                    <div class="form-group">
                                        <label for="content">Description</label>
                                        <textarea name="seo_description" id="seo_description" rows="8" class="form-control" placeholder="Enter SEO Description.">{{ old('seo_description', isset($page->seo_description) ? $page->seo_description: '')}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                            <option value="active" {{ old('status', isset($page->status) ? $page->status : '')=='active'?'selected="selected"':''}}>Active</option>
                                            <option value="in_active" {{ old('status', isset($page->status) ? $page->status : '')=='in_active'?'selected="selected"':''}}>Inactive</option>
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