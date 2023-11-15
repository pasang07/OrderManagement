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
                                        <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}"><i class="feather icon-home"></i></a></li>
                                        <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('blog.index')}}">Blogs</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">Blogs Category</a></li>
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
                                            <h5>Add Blog Category</h5>
                                        </div>
                                        <form method="post" action="{{route('blog-cat.store')}}" enctype="multipart/form-data" autocomplete="off" data-parsley-validate novalidate>
                                            {!! csrf_field() !!}
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Title</label>
                                                            <input type="text" class="form-control" name="title" id="title" value="{{ old('title', isset($banner->title) ? $banner->title: '')}}" placeholder="Enter Blog Category" required>
                                                        </div>
                                                        <span class="text-danger">{{ $errors->first('title') }}</span>
                                                        <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Submit</button>
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
                                            <h5>Blog Category List</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>S.N.</th>
                                                        <th>Title</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($categories as $k=>$cat)
                                                        <tr class="unread">
                                                            <td>{{$k+1}}</td>
                                                            <td>
                                                                <h6 class="mb-1">{{$cat->title}}</h6>
                                                            </td>
                                                            <td><i class="fas fa-edit" data-toggle="modal" data-target="#editModal-{{$k}}"></i> <i class="fas fa-trash" data-toggle="modal" data-target="#deleteModal-{{$k}}"></i>
                                                                <!-- edit -->
                                                                <div class="modal fade" id="editModal-{{$k}}" tabindex="-1" role="dialog">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="defaultModalLabel">Edit Category</h4>
                                                                            </div>
                                                                            <form method="post" action="{{route('blog-cat.update',$cat->id)}}" enctype="multipart/form-data" autocomplete="off" data-parsley-validate novalidate>
                                                                                {!! csrf_field() !!}
                                                                                <div class="card-body">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                <label>Title</label>
                                                                                                <input type="text" class="form-control" name="title" id="title" value="{{ old('title', isset($cat->title) ? $cat->title: '')}}" placeholder="Enter Blog Category" required>
                                                                                            </div>
                                                                                            <span class="text-danger">{{ $errors->first('title') }}</span>
                                                                                            <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Submit</button>
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
                                                                                Are you sure you want to delete <b>{{$cat->title}}</b>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <a href="{{route('blog-cat.destroy',$cat->id)}}" class="btn btn-danger">Delete</a>
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
                                                        {!! $categories->render() !!}
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

@endsection