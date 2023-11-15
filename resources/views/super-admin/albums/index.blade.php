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
                                        <li class="breadcrumb-item"><a href="javascript:">Albums</a></li>
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
                                            <h5>Albums List</h5>
                                        </div>
                                        @if(Auth::user()->role=='superadmin')
                                        <div class="button-card text-right ">
                                            <a href="{{route('albums.create')}}"><button type="button" class="btn btn-dark"><i class="fas fa-plus"></i> Add Albums</button></a>
                                            <div class="btn-group mb-2 mr-2">
                                                <button type="button" class="btn btn-danger">Action</button>
                                                <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="sr-only">Toggle Dropdown</span></button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" id="active" href="#!" data-id="albums">Enable</a>
                                                    <a class="dropdown-item" id="deactive" href="#!" data-id="albums">Disable</a>
                                                    <a class="dropdown-item" id="delete" href="#!" data-id="albums">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table id="sortable" class="table table-hover todo-list ui-sortable">
                                                    <thead>
                                                        <tr>
                                                            <th><span class="handle"><i class="fas fa-arrows-alt"></i></span></th>
                                                            <th>S.N.</th>
                                                            <th>Title</th>
                                                            <th>Gallery</th>
                                                            <th>Modified Date</th>
                                                            @if(Auth::user()->role=='superadmin')
                                                            <th>Action</th>
                                                            @endif
                                                            <th><div class="custom-control custom-checkbox select-all">
                                                                    <input type="checkbox" id="checkAll" class="custom-control-input">
                                                                    <label class="custom-control-label" for="checkAll"></label>
                                                                </div></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $orders =''; $table='albums'; ?>
                                                    @foreach($albums as $k=>$album)
                                                        <?php $orders .= $album->order . ',';
                                                        ?>
                                                    <tr id="{{$album->id}}">
                                                        <td class="move">
                                                            <span class="handle">
                                                                <i class="fa fa-ellipsis-v"></i>
                                                                <i class="fa fa-ellipsis-v"></i>
                                                            </span>
                                                        </td>
                                                        <td>{{$k+1}}</td>
                                                        <td>
                                                            <h6 class="mb-1">{{$album->title}}</h6>
                                                        </td>
                                                        <td>
                                                            <a href="{{route('gallery.index',$album->id)}}"><i class="fas fa-images"></i> {{$album->gallery->count()}}</a>
                                                        </td>
                                                        <td>
                                                            <h6 class="text-muted">Updated: {{date('d M, Y', strtotime($album->updated_at))}}</h6>
                                                            <h6 class="text-muted">Created: {{date('d M, Y', strtotime($album->created_at))}}</h6>
                                                        </td>
                                                        @if(Auth::user()->role=='superadmin')
                                                        <td>

                                                            <a href="{{route('albums.edit',$album->id)}}" ><button type="button" class="btn btn-icon btn-rounded btn-outline-primary"><i class="fas fa-edit"></i></button></a>
                                                            <button type="button" class="btn btn-icon btn-rounded btn-outline-danger" data-toggle="modal" data-target="#deleteModal-{{$k}}"><i class="fas fa-trash"></i></button>

                                                            <!-- delete -->
                                                            <div class="modal fade" id="deleteModal-{{$k}}" tabindex="-1" role="dialog">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title" id="defaultModalLabel">Attention !!!</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Are you sure you want to delete <b>{{$album->name}}</b>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <a href="{{route('albums.destroy',$album->id)}}" class="btn btn-danger">Delete</a>
                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        @endif
                                                        <td><div class="custom-control custom-checkbox select-1">
                                                                <input type="checkbox" class="custom-control-input" id="customCheck{{$k+1}}" name="id" value="{{$album->id}}">
                                                                <label class="custom-control-label" for="customCheck{{$k+1}}"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="justify-content-center">
                                                    <ul class="pagination">
                                                        {!! $albums->render() !!}
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