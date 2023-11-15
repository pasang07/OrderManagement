<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-8">
                <!-- [ form-element ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Faq Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" class="form-control" name="amenity_id" id="amenity_id" value="{{$amenity_id}}" readonly required>
                                    <div class="form-group">
                                        <label>Question <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="question" id="question" value="{{ old('question', isset($amenityFaq->question) ? $amenityFaq->question: '')}}" placeholder="Enter Question" required>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('question') }}</span>

                                    <div class="form-group">
                                        <label>Answer <span class="text-danger">*</span></label>
                                        <textarea rows="5" class="form-control" name="answer" id="answer" required>{{ old('answer', isset($amenityFaq->answer) ? $amenityFaq->answer: '')}}</textarea>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('answer') }}</span>
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
                                            <option value="active" {{ old('status', isset($amenityFaq->status) ? $amenityFaq->status : '')=='active'?'selected="selected"':''}}>Active</option>
                                            <option value="in_active" {{ old('status', isset($amenityFaq->status) ? $amenityFaq->status : '')=='in_active'?'selected="selected"':''}}>Inactive</option>
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