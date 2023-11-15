@extends('layouts.super-admin.layouts')
@section('content')
    <section class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <!-- [ breadcrumb ] start -->
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10"></h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">Product Batch</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ breadcrumb ] end -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Add Product Batch</h5>
                                        </div>
                                        <form method="post"  id="dynamic_form" autocomplete="off" data-parsley-validate novalidate name="add_name" id="add_name">
                                            {!! csrf_field() !!}
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <span id="result"></span>

                                                        <table class="table" id="user_table">
                                                            <thead>
                                                            <tr>
                                                                <th width="40%">Batch (ML)</th>
                                                                <th width="40%">No of bottle case</th>
                                                                <th width="20%">Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="adding"></tbody>
                                                        </table>
                                                        <button type="submit" class="btn btn-success" id="submit"><i class="fas fa-paper-plane"></i> Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- [ configuration table ] start -->
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Batch List</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>S.N.</th>
                                                        <th>Batch (ML)</th>
                                                        <th>No of bottle case</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($batches as $k=>$batch)
                                                        <tr class="unread">
                                                            <td>{{$k+1}}</td>
                                                            <td>
                                                                <h6 class="mb-1">{{$batch->batch_no}} ml</h6>
                                                            </td>
                                                            <td>
                                                                {{$batch->bottle_case}}
                                                            </td>
                                                            <td><i class="fas fa-edit" data-toggle="modal" data-target="#editModal-{{$k}}"></i> <i class="fas fa-trash" data-toggle="modal" data-target="#deleteModal-{{$k}}"></i>
                                                                <!-- edit -->
                                                                <div class="modal fade" id="editModal-{{$k}}" tabindex="-1" role="dialog">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="defaultModalLabel">Edit Room Amenity</h4>
                                                                            </div>
                                                                            <form method="post" action="{{route('productbatch.update',$batch->id)}}" enctype="multipart/form-data" autocomplete="off" data-parsley-validate novalidate>
                                                                                {!! csrf_field() !!}
                                                                                <div class="card-body">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                <label>Batch (ML)</label>
                                                                                                <input type="text" class="form-control" name="batch_no" id="batch_no" value="{{ old('batch_no', isset($batch->batch_no) ? $batch->batch_no: '')}}" placeholder="Enter Batch" required>
                                                                                            </div>
                                                                                            <span class="text-danger">{{ $errors->first('batch_no') }}</span>

                                                                                            <div class="form-group">
                                                                                                <label>No of Bottle Case</label>
                                                                                                <input type="text" class="form-control" name="bottle_case" id="bottle_case" value="{{ old('bottle_case', isset($batch->bottle_case) ? $batch->bottle_case: '')}}" placeholder="Enter bottle case" required>
                                                                                            </div>
                                                                                            <span class="text-danger">{{ $errors->first('bottle_case') }}</span>

                                                                                            <button type="submit" class="btn btn-warning"><i class="fas fa-paper-plane"></i> Update Batch</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- delete -->
                                                                <div class="modal fade" id="deleteModal-{{$k}}" tabindex="-1" role="dialog">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="defaultModalLabel">Attention !!!</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Are you sure you want to delete <b>{{$batch->batch_no}}</b>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <a href="{{route('productbatch.destroy',$batch->id)}}" class="btn btn-danger">Delete</a>
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="justify-content-center">
                                                    <ul class="pagination">
                                                        {!! $batches->render() !!}
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- [ configuration table ] end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('page-specific-scripts')
    <script>
        $(document).ready(function(){

            var count = 1;

            dynamic_field(count);

            function dynamic_field(number)
            {
                html = '<tr>';
                html += '<td><input type="number" class="form-control" name="batch_no[]" placeholder="Enter batch"></td>';
                html += '<td><input type="number" class="form-control" name="bottle_case[]" placeholder="Enter bottle case"></td>';

                if(number > 1)
                {
                    html += '<td><button type="button" name="remove" class="btn btn-danger remove">-</button></td></tr>';
                    $('#adding').append(html);
                }
                else
                {
                    html += '<td><button type="button" name="add" id="add" class="btn btn-secondary">+</button></td></tr>';
                    $('#adding').html(html);
                }
            }

            $(document).on('click', '#add', function(){
                count++;
                dynamic_field(count);
            });

            $(document).on('click', '.remove', function(){
                count--;
                $(this).closest("tr").remove();
            });

            $('#dynamic_form').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    url:'{{ route("productbatch.insert") }}',
                    method:'post',
                    data:$(this).serialize(),
                    dataType:'json',
                    beforeSend:function(){
                        $('#save').attr('disabled','disabled');
                    },
                    success:function(data)
                    {
                        if(data.error)
                        {
                            var error_html = '';
                            for(var count = 0; count < data.error.length; count++)
                            {
                                error_html += '<p>'+data.error[count]+'</p>';
                            }
                            $('#result').html('<div class="alert alert-danger">'+error_html+'</div>');
                        }
                        else
                        {
                            dynamic_field(1);
                            swal({
                                text: "Batches added successfully.",
                                title: "Success !!!",
                                icon: "success",
                                buttons: "Ok",
                            }).then(function() {
                                window.location = "{{route('productbatch.index')}}";
                            });
//                            $('#result').html('<div class="alert alert-success">'+data.success+'</div>');

                        }
                        $('#save').attr('disabled', false);
                    }
                })
            });

        });
    </script>
@endsection