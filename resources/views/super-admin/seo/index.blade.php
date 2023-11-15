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
                                        <li class="breadcrumb-item"><a href="javascript:">SEO</a></li>
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
                                            <h5>SEO</h5>
                                        </div>
                                        <div class="button-card text-right ">
                                            <a href="{{route('seo.create')}}"><button type="button" class="btn btn-dark"><i class="fas fa-plus"></i> Add SEO</button></a>
                                            <div class="btn-group mb-2 mr-2">
                                                <button type="button" class="btn btn-danger">Action</button>
                                                <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="sr-only">Toggle Dropdown</span></button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" id="delete" href="#!" data-id="seo">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>S.N.</th>
                                                            <th>Page</th>
                                                            {{--<th>Image</th>--}}
                                                            <th>Modified Date</th>
                                                            <th>Action</th>
                                                            <th><div class="custom-control custom-checkbox select-all">
                                                                    <input type="checkbox" id="checkAll" class="custom-control-input">
                                                                    <label class="custom-control-label" for="checkAll"></label>
                                                                </div></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($seos as $k=>$seo)
                                                    <tr class="unread" id="{{$seo->id}}">
                                                        <td>{{$k+1}}</td>
                                                        <td>
                                                            <h6 class="mb-1">{{$seo->title}}</h6>
                                                        </td>

                                                        {{--<td>--}}
                                                            {{--<div class="image-trap">--}}
                                                                {{--<a href="{{asset('uploads/SEO/thumbnail/'.$seo->image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class=" img-responsive">--}}
                                                                    {{--<img class="" style="width:70px;" src="{{asset('uploads/SEO/thumbnail/'.$seo->image)}}" alt="activity-user">--}}
                                                                    {{--<div class="g-title">--}}
                                                                        {{--<i class="fa fa-search"></i>--}}
                                                                    {{--</div>--}}
                                                                {{--</a>--}}
                                                            {{--</div>--}}
                                                        {{--</td>--}}
                                                        <td>
                                                            <h6 class="text-muted">Updated: {{date('d M, Y', strtotime($seo->updated_at))}}</h6>
                                                            <h6 class="text-muted"> Created: {{date('d M, Y', strtotime($seo->created_at))}}</h6>
                                                        </td>
                                                        <td>
                                                            <a href="{{route('seo.edit',$seo->id)}}" ><button type="button" class="btn btn-icon btn-rounded btn-outline-primary"><i class="fas fa-edit"></i></button></a>
                                                            <button type="button" class="btn btn-icon btn-rounded btn-outline-danger" data-toggle="modal" data-target="#deleteModal-{{$k}}"><i class="fas fa-trash"></i></button>

                                                            <!-- delete -->
                                                            <div class="modal fade" id="deleteModal-{{$k}}" tabindex="-1" role="dialog">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title" id="defaultModalLabel">Attention !!!</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Are you sure you want to delete <b>{{$seo->title}}</b> Page ?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <a href="{{route('seo.destroy',$seo->id)}}" class="btn btn-danger">Delete</a>
                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><div class="custom-control custom-checkbox select-1">
                                                                <input type="checkbox" class="custom-control-input" id="customCheck{{$k+1}}" name="id" value="{{$seo->id}}">
                                                                <label class="custom-control-label" for="customCheck{{$k+1}}"></label>
                                                            </div></td>
                                                    </tr>
                                                    @endforeach
                                                   </tbody>
                                                </table>
                                                <div class="justify-content-center">
                                                    <ul class="pagination">
                                                        {!! $seos->render() !!}
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