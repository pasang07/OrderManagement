<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <!-- [ form-element ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Page SEO</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    {{--<div class="form-group">--}}
                                        {{--<label>Title</label>--}}
                                        {{--<input type="text" class="form-control" name="title" id="title" value="{{ old('title', isset($seo->title) ? $seo->title: '')}}" placeholder="Enter SEO" parsley-trigger="change">--}}
                                    {{--</div>--}}
                                    {{--<span class="text-danger">{{ $errors->first('title') }}</span>--}}
                                    <div class="form-group">
                                        <label>Select Page</label>
                                        <select class="form-control" id="slug" name="slug" required>
                                            <option value="">--Select Page--</option>
                                            <option value="about-us" {{ old('slug', isset($seo->slug) ? $seo->slug : '')=='about-us'?'selected="selected"':''}}>About Us</option>
                                            <option value="blogs" {{ old('slug', isset($seo->slug) ? $seo->slug : '')=='blogs'?'selected="selected"':''}}>Blog</option>
                                            <option value="news-notices" {{ old('slug', isset($seo->slug) ? $seo->slug : '')=='news-notices'?'selected="selected"':''}}>News / Notices</option>
                                            <option value="services" {{ old('slug', isset($seo->slug) ? $seo->slug : '')=='services'?'selected="selected"':''}}>Services</option>
                                            {{--<option value="albums" {{ old('slug', isset($seo->slug) ? $seo->slug : '')=='albums'?'selected="selected"':''}}>Gallery</option>--}}
                                            <option value="contact-us" {{ old('slug', isset($seo->slug) ? $seo->slug : '')=='contact-us'?'selected="selected"':''}}>Contact Us</option>
                                            {{--<option value="testimonial" {{ old('slug', isset($seo->slug) ? $seo->slug : '')=='testimonial'?'selected="selected"':''}}>Client Reviews</option>--}}
                                            {{--<option value="search" {{ old('slug', isset($seo->slug) ? $seo->slug : '')=='search'?'selected="selected"':''}}>Search</option>--}}
                                        </select>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('slug') }}</span>
                                    <div class="row">
                                        <div class="@if(isset($seo->image))col-md-8 @else col-md-12 @endif"><div class="form-group">
                                                <label>Upload Banner Image <label class="img-size">(Size:-1920x600)</label></label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="image" name="image" value="{{ old('image', isset($seo->image) ? $seo->image: '')}}" @if(!isset($seo->image))required @endif>
                                                    <label class="custom-file-label" for="image">Choose file...</label>
                                                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                                                </div>
                                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                            </div></div>
                                        @if(isset($seo->image))
                                            <div class="col-md-4">
                                                <div class="image-trap">
                                                    <a href="{{asset('uploads/SEO/thumbnail/'.$seo->image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class=" img-responsive">
                                                        <img class="img-thumbnail image_list"  src="{{asset('uploads/SEO/thumbnail/'.$seo->image)}}" alt="activity-user">
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
            <div class="col-sm-12">
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
                                        <input type="text" class="form-control" name="seo_title" id="seo_title" value="{{ old('seo_title', isset($seo->seo_title) ? $seo->seo_title: '')}}" placeholder="Enter SEO Title">
                                    </div>
                                    <div class="form-group">
                                        <label>Seo Keywords</label>
                                        <input type="text" id="tags" class="tagsinput form-control" name="seo_keywords" value="{{ old('seo_keywords', isset($seo->seo_keywords) ? $seo->seo_keywords: '')}}" placeholder="Enter SEO Keywords">
                                    </div>
                                    <div class="form-group">
                                        <label for="content">Description</label>
                                        <textarea name="seo_description" id="seo_description" rows="8" class="form-control" placeholder="Enter SEO Description.">{{ old('seo_description', isset($seo->seo_description) ? $seo->seo_description: '')}}</textarea>
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