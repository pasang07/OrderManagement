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
                                        <li class="breadcrumb-item"><a href="{{route('service.index')}}">Services</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">Image</a></li>
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
                                <!-- [ configuration table ] start -->
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Image List</h5>
                                        </div>
                                        <div class="button-card text-right ">
                                            <a href="{{route('amenity-gallery.create',$amenity_id)}}"><button type="button" class="btn btn-dark"><i class="fas fa-plus"></i> Add Images</button></a>
                                            <div class="btn-group mb-2 mr-2">
                                                <button type="button" class="btn btn-danger">Action</button>
                                                <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="sr-only">Toggle Dropdown</span></button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" id="active" href="#!" data-id="amenityGallery">Enable</a>
                                                    <a class="dropdown-item" id="deactive" href="#!" data-id="amenityGallery">Disable</a>
                                                    <a class="dropdown-item" id="delete" href="#!" data-id="amenityGallery">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table id="sortable" class="table table-hover todo-list ui-sortable">
                                                    <thead>
                                                        <tr>
                                                            <th><span class="handle"><i class="fas fa-arrows-alt"></i></span></th>
                                                            <th>S.N.</th>
                                                            <th>Image</th>
                                                            <th>Modified Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                            <th><div class="custom-control custom-checkbox select-all">
                                                                    <input type="checkbox" id="checkAll" class="custom-control-input">
                                                                    <label class="custom-control-label" for="checkAll"></label>
                                                                </div></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $orders =''; $table='amenity_galleries'; ?>
                                                    @foreach($amenityGalleries as $k=>$amenityGallery)
                                                        <?php $orders .= $amenityGallery->order . ',';
                                                        ?>
                                                    <tr id="{{$amenityGallery->id}}">
                                                        <td class="move">
                                                            <span class="handle">
                                                                <i class="fa fa-ellipsis-v"></i>
                                                                <i class="fa fa-ellipsis-v"></i>
                                                            </span>
                                                        </td>
                                                        <td>{{$k+1}}</td>
                                                        <td>
                                                            <div class="image-trap">
                                                                <a href="{{asset('uploads/AmenityGallery/thumbnail/'.$amenityGallery->image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class="img-responsive">
                                                                    <img class="" style="width:70px;" src="{{asset('uploads/AmenityGallery/thumbnail/'.$amenityGallery->image)}}" alt="no image">
                                                                    <div class="g-title">
                                                                        <i class="fa fa-search"></i>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h6 class="text-muted">Updated: {{date('d M, Y', strtotime($amenityGallery->updated_at))}}</h6>
                                                            <h6 class="text-muted">Created: {{date('d M, Y', strtotime($amenityGallery->created_at))}}</h6>
                                                        </td>
                                                        <td>@if($amenityGallery->status=='active')<a href="#!" class="label theme-bg text-white f-12">Enable</a>@else<a href="#!" class="label theme-bg2 text-white f-12">Disable</a>@endif</td>
                                                        <td>
                                                            <a href="{{url('super-admin/amenity-gallery/edit/'.$amenityGallery->id.'/'.$amenity_id)}}" ><button type="button" class="btn btn-icon btn-rounded btn-outline-primary"><i class="fas fa-edit"></i></button></a>
                                                            <button type="button" class="btn btn-icon btn-rounded btn-outline-danger" data-toggle="modal" data-target="#deleteModal-{{$k}}"><i class="fas fa-trash"></i></button>

                                                            <!-- delete -->
                                                            <div class="modal fade" id="deleteModal-{{$k}}" tabindex="-1" role="dialog">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title" id="defaultModalLabel">Attention !!!</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Are you sure you want to delete?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <a href="{{route('amenity-gallery.destroy',$amenityGallery->id)}}" class="btn btn-danger">Delete</a>
                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><div class="custom-control custom-checkbox select-1">
                                                                <input type="checkbox" class="custom-control-input" id="customCheck{{$k+1}}" name="id" value="{{$amenityGallery->id}}">
                                                                <label class="custom-control-label" for="customCheck{{$k+1}}"></label>
                                                            </div></td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="justify-content-center">
                                                    <ul class="pagination">
                                                        {!! $amenityGalleries->render() !!}
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#sortable').tableDnD({
                onDrop: function (table, row) {
//            alert($.tableDnD.serialize());
                    $.ajax({method:'POST',url:'{{route('ajax.sortable')}}',data:{ids_order: $.tableDnD.serialize(), orders: '<?php echo $orders; ?>', table: '<?php echo $table; ?>', _token: '{!! csrf_token() !!}'}});
                }
            });
        });
    </script>
@endsection