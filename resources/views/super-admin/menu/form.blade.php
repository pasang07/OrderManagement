<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-8">
                <!-- [ form-element ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Menu Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="status">Parent</label>
                                        <select class="form-control" id="parent_id" name="parent_id" required>
                                            <?php
                                            if (isset($nav)) {
                                                $options = array(0 => 'None') + TreeHelper::selectOptions('navs', $base_id = 0, $id = $nav->id, $terms = null, $order_by = 'order', $order = 'asc');
                                            } else {
                                                $options = array(0 => 'None') + TreeHelper::selectOptions('navs', $base_id = 0, $id = null, $terms = null, $order_by = 'order', $order = 'asc');
                                            }
                                            ?>
                                                @foreach($options as $k=> $option)
                                                    <option value="{{$k}}" {{ old('parent_id', isset($parentId) ? $parentId : '')==$k?'selected="selected"':''}}>{{$option}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('parent_id') }}</span>
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select class="form-control" id="type" name="type" onchange="changeType(this.value)" required>
                                            <option value="">--select--</option>
                                            <option value="none" {{ old('type', isset($nav->type) ? $nav->type : '')=='none'?'selected="selected"':''}}>None</option>
                                            <option value="pages" {{ old('type', isset($nav->type) ? $nav->type : '')=='pages'?'selected="selected"':''}}>Page</option>
                                            <option value="software" {{ old('type', isset($nav->type) ? $nav->type : '')=='software'?'selected="selected"':''}}>Software</option>
                                            {{--<option value="destinations" {{ old('type', isset($nav->type) ? $nav->type : '')=='destinations'?'selected="selected"':''}}>Destinations</option>--}}
                                            <option value="amenities" {{ old('type', isset($nav->type) ? $nav->type : '')=='amenities'?'selected="selected"':''}}>Services</option>
                                            {{--<option value="link" {{ old('type', isset($nav->type) ? $nav->type : '')=='link'?'selected="selected"':''}}>Link</option>--}}
                                            <option value="route" {{ old('type', isset($nav->type) ? $nav->type : '')=='route'?'selected="selected"':''}}>Route</option>
                                        </select>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('type') }}</span>
                                    <div class="form-group" id="title_section">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title', isset($nav->title) ? $nav->title: '')}}" placeholder="Enter Menu Title" parsley-trigger="change" required>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                    <div class="form-group" id="url_section">
                                        <label>Url</label>
                                        <input type="text" class="form-control" name="url" id="url" value="{{ old('url', isset($nav->url) ? $nav->url: '')}}" placeholder="Enter Url" parsley-trigger="change">
                                    </div>
                                    <span class="text-danger">{{ $errors->first('url') }}</span>
                                    <div class="form-group" id="group">
                                        <?php if(isset($nav->id)){
                                            ?>
                                            @include('super-admin.menu.nav-type-edit')
                                            <?php }else{ ?>
                                            @include('super-admin.menu.nav-type')
                                            <?php } ?>
                                    </div>

                                    {{--<div class="row" id="banner_image">--}}
                                        {{--<div class="@if(isset($nav->image))col-md-8 @else col-md-12 @endif"><div class="form-group">--}}
                                                {{--<label>Upload Page Image <label class="img-size">(Size:-50x50)</label></label>--}}
                                                {{--<div class="custom-file">--}}
                                                    {{--<input type="file" class="custom-file-input" id="image" name="image" value="{{ old('image', isset($nav->image) ? $nav->image: '')}}">--}}
                                                    {{--<label class="custom-file-label" for="image">Choose file...</label>--}}
                                                    {{--<div class="invalid-feedback">Example invalid custom file feedback</div>--}}
                                                {{--</div>--}}
                                                {{--<span class="text-danger">{{ $errors->first('image') }}</span>--}}
                                            {{--</div></div>--}}
                                        {{--@if(isset($nav->image))--}}
                                            {{--<div class="col-md-4">--}}
                                                {{--<div class="image-trap">--}}
                                                    {{--<div class="custom-control custom-checkbox select-1">--}}
                                                        {{--<input type="checkbox" class="custom-control-input" id="customCheck"  name="delete_image" value="delete_image">--}}
                                                        {{--<label class="custom-control-label" for="customCheck" title="Check for delete this image"></label>--}}
                                                    {{--</div>--}}
                                                    {{--<a href="{{asset('uploads/Nav/thumbnail/'.$nav->image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class=" img-responsive">--}}
                                                        {{--<img class="img-thumbnail image_list"  src="{{asset('uploads/Nav/thumbnail/'.$nav->image)}}" alt="activity-user">--}}
                                                    {{--</a>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
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
                                        <label for="status">Show in New Page?</label>
                                        <select class="form-control" id="target" name="target" required>
                                            <option value="_self" {{ old('target', isset($nav->target) ? $nav->target : '')=='_self'?'selected="selected"':''}}>No</option>
                                            <option value="_blank" {{ old('target', isset($nav->target) ? $nav->target : '')=='_blank'?'selected="selected"':''}}>Yes</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="active" {{ old('status', isset($nav->status) ? $nav->status : '')=='active'?'selected="selected"':''}}>Active</option>
                                            <option value="in_active" {{ old('status', isset($nav->status) ? $nav->status : '')=='in_active'?'selected="selected"':''}}>Inactive</option>
                                        </select>
                                    </div>
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