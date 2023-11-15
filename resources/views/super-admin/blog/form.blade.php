<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-8">
                <!-- [ form-element ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Blog Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title', isset($blog->title) ? $blog->title: '')}}" placeholder="Enter Blog Title" parsley-trigger="change" required>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                    <div class="form-group">
                                        <label for="status">Category <span class="text-danger">*</span></label>
                                        <select class="form-control" id="category_id" name="category_id" required>
                                            <option value="">--Choose Blog Category --</option>
                                            @foreach($categories as $cat)
                                            <option value="{{$cat->id}}" {{ old('category_id', isset($blog->category_id) ? $blog->category_id : '')==$cat->id?'selected="selected"':''}}>{{$cat->title}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('category_id') }}</span>
                                    <div class="form-group">
                                        <label>Author</label>
                                        <input type="text" class="form-control" name="author" id="author" value="{{ old('author', isset($blog->author) ? $blog->author: '')}}" placeholder="Enter Author Name">
                                    </div>
                                    <span class="text-danger">{{ $errors->first('author') }}</span>

                                    <div class="row">
                                        <div class="@if(isset($blog->image))col-md-8 @else col-md-12 @endif"><div class="form-group">
                                                <label>Upload Blog Image <span class="text-danger">*</span> <label class="img-size">(Size:-370x270)</label></label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="image" name="image" value="{{ old('image', isset($blog->image) ? $blog->image: '')}}" @if(!isset($blog->image))required @endif>
                                                    <label class="custom-file-label" for="image">Choose file...</label>
                                                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                                                </div>
                                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                            </div></div>
                                        @if(isset($blog->image))
                                            <div class="col-md-4">
                                                <div class="image-trap">
                                                    <a href="{{asset('uploads/Blog/thumbnail/'.$blog->image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class=" img-responsive">
                                                        <img class="img-thumbnail image_list"  src="{{asset('uploads/Blog/thumbnail/'.$blog->image)}}" alt="activity-user">
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="@if(isset($blog->inner_image))col-md-8 @else col-md-12 @endif"><div class="form-group">
                                                <label>Upload Blog Inner Image <span class="text-danger">*</span> <label class="img-size">(Size:-770x430)</label></label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="inner_image" name="inner_image" value="{{ old('inner_image', isset($blog->inner_image) ? $blog->inner_image: '')}}" @if(!isset($blog->inner_image)) required @endif>
                                                    <label class="custom-file-label" for="inner_image">Choose file...</label>
                                                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                                                </div>
                                                <span class="text-danger">{{ $errors->first('inner_image') }}</span>
                                            </div></div>
                                        @if(isset($blog->inner_image))
                                            <div class="col-md-4">
                                                <div class="image-trap">
                                                    <a href="{{asset('uploads/Blog/Inner/thumbnail/'.$blog->inner_image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class="img-responsive">
                                                        <img class="img-thumbnail image_list"  src="{{asset('uploads/Blog/Inner/thumbnail/'.$blog->inner_image)}}" alt="no image">
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="content">Content <span class="text-danger">*</span> </label>
                                        <textarea name="content" id="editor" rows="8" class="form-control" placeholder="Enter content here." required>{{ old('content', isset($blog->content) ? $blog->content: '')}}</textarea>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('content') }}</span>

                                    {{--<div class="form-group">--}}
                                        {{--<label>Blog Tags</label>--}}
                                        {{--<input type="text" id="tagsinput" class="tagsinput form-control tags" name="tags" value="{{ old('tags', isset($blog->tags) ? $blog->tags: '')}}" placeholder="Enter Blog Tags" parsley-trigger="change" required>--}}
                                    {{--</div>--}}
                                    {{--<span class="text-danger">{{ $errors->first('tags') }}</span>--}}
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
                                        <input type="text" class="form-control" name="seo_title" id="seo_title" value="{{ old('seo_title', isset($blog->seo_title) ? $blog->seo_title: '')}}" placeholder="Enter SEO Title" parsley-trigger="change">
                                    </div>
                                    <div class="form-group">
                                        <label>Seo Keywords</label>
                                        <input type="text" id="tags" class="tagsinput form-control" name="seo_keywords" value="{{ old('seo_keywords', isset($blog->seo_keywords) ? $blog->seo_keywords: '')}}" placeholder="Enter SEO Keywords" parsley-trigger="change">
                                    </div>
                                    <div class="form-group">
                                        <label for="content">Description</label>
                                        <textarea name="seo_description" id="seo_description" rows="8" class="form-control" placeholder="Enter SEO Description.">{{ old('seo_description', isset($blog->seo_description) ? $blog->seo_description: '')}}</textarea>
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
                                            <option value="active" {{ old('status', isset($blog->status) ? $blog->status : '')=='active'?'selected="selected"':''}}>Active</option>
                                            <option value="in_active" {{ old('status', isset($blog->status) ? $blog->status : '')=='in_active'?'selected="selected"':''}}>Inactive</option>
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