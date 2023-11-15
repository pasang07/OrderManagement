<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-8">
                <!-- [ form-element ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Image Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" class="form-control" name="amenity_id" id="amenity_id" value="{{$amenity_id}}" readonly required>

                                    <div class="row">
                                        <div class="@if(isset($amenityGallery->image))col-md-8 @else col-md-12 @endif"><div class="form-group">
                                                <label>Upload Image(s) <label class="bg-dark text-white">[Size: 900x600]</label></label>
                                                <div class="custom-file">
                                                    <input type="file" multiple class="custom-file-input" id="image" @if(isset($amenityGallery->image)) name="image" @else name="image[]" @endif value="" @if(!isset($amenityGallery->image))required @endif>
                                                    <label class="custom-file-label" for="image">Choose file...</label>
                                                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                                                </div>
                                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                            </div></div>
                                        @if(isset($amenityGallery->image))
                                            <div class="col-md-4">
                                                <div class="image-trap">
                                                    <a href="{{asset('uploads/AmenityGallery/thumbnail/'.$amenityGallery->image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class=" img-responsive">
                                                        <img class="img-thumbnail image_list"  src="{{asset('uploads/AmenityGallery/thumbnail/'.$amenityGallery->image)}}" alt="no-image">
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
                                            <option value="active" {{ old('status', isset($amenityGallery->status) ? $amenityGallery->status : '')=='active'?'selected="selected"':''}}>Active</option>
                                            <option value="in_active" {{ old('status', isset($amenityGallery->status) ? $amenityGallery->status : '')=='in_active'?'selected="selected"':''}}>Inactive</option>
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