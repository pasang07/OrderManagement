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
                                        <li class="breadcrumb-item"><a href="javascript:">Contact Messages</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ breadcrumb ] end -->
                        <div class="main-body">
                                <div class="page-wrapper">
                                        <!-- [ Main Content ] start -->
                                    {{--<button class="btn btn-success">Compose</button>--}}
                                    <form method="post" action="{{route('contact.mail')}}" enctype="multipart/form-data" autocomplete="off">
                                        {!! csrf_field() !!}
                                        <div class="row">
                                    <!-- [ configuration table ] start -->
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Contact Messages List</h5>
                                        </div>
                                            <div class="button-card text-right ">
                                                <input type="submit" class="btn btn-success" value="Compose / Reply Mail">
                                            <!--<div class="btn-group mb-2 mr-2">-->
                                            <!--    <button type="button" class="btn btn-danger">Action</button>-->
                                            <!--    <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="sr-only">Toggle Dropdown</span></button>-->
                                            <!--    <div class="dropdown-menu">-->
                                            <!--       <a class="dropdown-item" id="delete" href="#!" data-id="contact">Delete</a>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>S.N.</th>
                                                        <th>Name</th>
                                                        <th>Subject</th>
                                                        <th>Sent At</th>
                                                        <th>Action</th>
                                                        <th><div class="custom-control custom-checkbox select-all">
                                                                <input type="checkbox" id="checkAll" class="custom-control-input">
                                                                <label class="custom-control-label" for="checkAll"></label>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="table-to-refresh">
                                                    @foreach($contacts as $k=>$contact)
                                                        <tr class="unread">
                                                            <td>{{$k+1}}</td>
                                                            <td>
                                                                <h6 class="mb-1" @if($contact->is_read == "no") style="font-weight: bold;" @endif>{{$contact->name}}</h6>
                                                                <a href="mailto:{{$contact->email}}" class="text-info">{{$contact->email}}</a>
                                                            </td>
                                                            <td>
                                                                <h6 @if($contact->is_read == "no") style="font-weight: bold;" @endif>{{$contact->subject}}</h6>
                                                            </td>
                                                            <td>
                                                               <p @if($contact->is_read == "no") style="font-weight: bold;" @endif>{{$contact->created_at->diffForHumans()}}</p>
                                                            </td>
                                                            <td>
                                                                <a href="{{route('contact.read', $contact->id)}}" type="button" class="btn btn-icon btn-rounded btn-outline-info"><i class="fas fa-eye"></i></a>

                                                                <button type="button" class="btn btn-icon btn-rounded btn-outline-danger" data-toggle="modal" data-target="#deleteModal-{{$k}}"><i class="fas fa-trash"></i></button>
                                                                <!-- delete -->
                                                                <div class="modal fade" id="deleteModal-{{$k}}" tabindex="-1" role="dialog">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="defaultModalLabel">Attention !!!</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Are you sure you want to delete <b>{{$contact->email}}</b>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <a href="{{route('contact.destroy',$contact->id)}}" class="btn btn-danger">Delete</a>
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td><div class="custom-control custom-checkbox select-1">
                                                                    <input type="checkbox" class="custom-control-input" id="customCheck{{$k+1}}" name="email[]" value="{{$contact->email}}">
                                                                    <input type="checkbox" class="custom-control-input" id="customCheck{{$k+1}}" name="id" value="{{$contact->id}}">
                                                                    <label class="custom-control-label" for="customCheck{{$k+1}}"></label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="justify-content-center">
                                                    <ul class="pagination">
                                                        {!! $contacts->render() !!}
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- [ configuration table ] end -->
                            </div>
                                    </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('page-specific-scripts')

@endsection