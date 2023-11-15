<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <!-- [ form-element ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Minimum Order Quantity</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="status">Product <span class="text-danger">*</span></label>
                                        <select class="form-control" id="productId" name="product_id" required>
                                            <option value="">Choose Product</option>
                                            @foreach($products as $product)
                                                <option value="{{$product->id}}" {{ old('product_id', isset($moq->product_id) ? $moq->product_id : '')==$product->id?'selected="selected"':''}}>{{$product->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('product_id') }}</span>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{$site_data->product_format}} <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="batch_no" id="batch_no" required value="{{ old('batch_no', isset($moq->batch_no) ? $moq->batch_no: '')}}" placeholder="Enter Volume">
                                    </div>
                                    <span class="text-danger">{{ $errors->first('batch_no') }}</span>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{$site_data->product_type}} <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="bottle_case" id="bottle_case" required placeholder="0" value="{{ old('bottle_case', isset($moq->bottle_case) ? $moq->bottle_case: '')}}" >
                                    </div>
                                    <span class="text-danger">{{ $errors->first('bottle_case') }}</span>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Minimum Order (case wise) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="moq_low" id="moq_low" required placeholder="0" value="{{ old('moq_low', isset($moq->moq_low) ? $moq->moq_low: '')}}" >
                                    </div>
                                    <span class="text-danger">{{ $errors->first('moq_low') }}</span>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Higher Order (case wise) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="moq_high" id="moq_high" required placeholder="0" value="{{ old('moq_high', isset($moq->moq_high) ? $moq->moq_high: '')}}" >
                                    </div>
                                    <span class="text-danger">{{ $errors->first('moq_high') }}</span>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Add Rate per bottle [USD $]<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="rate" id="rate" min="1" required placeholder="0" value="{{ old('rate', isset($moq->rate) ? $moq->rate: '')}}">
                                        {{--<input type="text" class="form-control" name="rate" id="rate" required placeholder="0" value="{{ old('rate', isset($moq->rate) ? $moq->rate: '')}}" onkeyup="calculateNow()">--}}
                                    </div>
                                    <span class="text-danger">{{ $errors->first('rate') }}</span>
                                </div>
                                {{--<div class="col-md-4">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<label>Amount [USD $]</label>--}}
                                        {{--<input type="text" class="form-control" name="amount" id="amount" required readonly placeholder="0" value="{{ old('amount', isset($moq->amount) ? $moq->amount: '')}}">--}}
                                    {{--</div>--}}
                                    {{--<span class="text-danger">{{ $errors->first('amount') }}</span>--}}
                                {{--</div>--}}
                                <div class="col-md-12 m-t-20">
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
