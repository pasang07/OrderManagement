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
                                    <div class="form-group rep">
                                        <div class="col-md-12 m-t-10">
                                            <div data-repeater-list="arrayName" class="repeateList">
                                                <div data-repeater-item>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="status">Product <span class="text-danger">*</span></label>
                                                                <select class="form-control" id="productId" name="product_id" required>
                                                                    <option value="">Choose Product</option>
                                                                    @foreach($products as $product)
                                                                        <option value="{{$product->id}}">{{$product->title}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <span class="text-danger">{{ $errors->first('product_id') }}</span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{$site_data->product_format}} <span class="text-danger">*</span></label>
                                                                <input type="number" class="form-control" name="batch_no" id="batch_no" required placeholder="Enter Batch">
                                                            </div>
                                                            <span class="text-danger">{{ $errors->first('batch_no') }}</span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>{{$site_data->product_type}} <span class="text-danger">*</span></label>
                                                                <input type="number" class="form-control" name="bottle_case" id="bottle_case" required placeholder="0">
                                                            </div>
                                                            <span class="text-danger">{{ $errors->first('bottle_case') }}</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Minimum Order (case wise) <span class="text-danger">*</span></label>
                                                                <input type="number" class="form-control" name="moq_low" id="moq_low" required placeholder="0" >
                                                            </div>
                                                            <span class="text-danger">{{ $errors->first('moq_low') }}</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Higher Order (case wise) <span class="text-danger">*</span></label>
                                                                <input type="number" class="form-control" name="moq_high" id="moq_high" required placeholder="0" >
                                                            </div>
                                                            <span class="text-danger">{{ $errors->first('moq_high') }}</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Add Rate per bottle [{{$site_data->currency_format}}]<span class="text-danger">*</span></label>
                                                                <input type="number" class="form-control" name="rate" id="rate" min="1" required placeholder="0" value="">
                                                            </div>
                                                            <span class="text-danger">{{ $errors->first('rate') }}</span>
                                                        </div>
                                                        {{--<div class="col-md-3">--}}
                                                            {{--<div class="form-group">--}}
                                                                {{--<label>Amount [USD $]</label>--}}
                                                                {{--<input type="number" class="form-control" name="amount" id="amount" required readonly placeholder="0">--}}
                                                            {{--</div>--}}
                                                            {{--<span class="text-danger">{{ $errors->first('amount') }}</span>--}}
                                                        {{--</div>--}}

                                                        <div class="col-md-3">
                                                            <div class="pull-right repeater-remove-btn">
                                                                <button data-repeater-delete type="button" class="btn btn-danger remove-btn">
                                                                    Remove
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr size="50" noshade="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="repeater-heading">
                                            <button data-repeater-create type="button" class="btn btn-primary pt-2 pull-right repeater-add-btn m-l-15">
                                                <i class="fas fa-plus"></i> ADD MORE
                                            </button>
                                        </div>
                                    </div>

                                </div>
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