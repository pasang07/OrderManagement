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
                                        <li class="breadcrumb-item"><a href="javascript:">Customers</a></li>
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
                                            <h5>Customer List</h5>
                                        </div>
                                        <div class="button-card text-right">
                                            <a href="{{route('client.create')}}"><button type="button" class="btn btn-dark"><i class="fas fa-plus"></i> Add Customer</button></a>
                                            {{--<div class="btn-group mb-2 mr-2">--}}
                                                {{--<button type="button" class="btn btn-danger">Action</button>--}}
                                                {{--<button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="sr-only">Toggle Dropdown</span></button>--}}
                                                {{--<div class="dropdown-menu">--}}
                                                    {{--<a class="dropdown-item" id="active" href="#!" data-id="user">Enable</a>--}}
                                                    {{--<a class="dropdown-item" id="deactive" href="#!" data-id="user">Disable</a>--}}
                                                    {{--<a class="dropdown-item" id="delete" href="#!" data-id="user">Delete</a>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>S.N.</th>
                                                        <th>Name</th>
                                                        <th>Modified Date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                        <th></th>
                                                        <th>
                                                           Agent Name
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($users as $k=>$user)
                                                        <?php
                                                        if($user->refer_by == 'none'){
                                                            $agent_title = "No Agent";
                                                        }else{
                                                            $agent_title = \App\Models\Model\SuperAdmin\User\User::where('id', $user->refer_by)->first()->name;
                                                        }
                                                        ?>
                                                    <tr class="unread">
                                                        <td>{{$k+1}}</td>
                                                        <td>
                                                            <h6 class="mb-1">{{$user->name}} </h6>
                                                        </td>
                                                        <td>
                                                            <h6 class="text-muted">Updated: {{date('d M, Y', strtotime($user->updated_at))}}</h6>
                                                            <h6 class="text-muted">Created: {{date('d M, Y', strtotime($user->created_at))}}</h6>
                                                        </td>
                                                        <td>@if($user->is_verified == 1)<a href="#!" class="label label-success">Verified</a>@else<a href="#!" class="label label-danger">Not Verified</a>@endif</td>
                                                        <td><a href="{{route('client.edit',$user->id)}}" ><i class="fas fa-edit"></i></a>
                                                        <i class="fas fa-trash" data-toggle="modal" data-target="#deleteModal-{{$k}}"></i>
                                                            <!-- delete -->
                                                            <div class="modal fade" id="deleteModal-{{$k}}" tabindex="-1" role="dialog">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title" id="defaultModalLabel">Attention !!!</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Are you sure you want to delete <b>{{$user->name}}</b>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <a href="{{route('client.destroy',$user->id)}}" class="btn btn-danger">Delete</a>
                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        
                                                        <td>
                                                          @if($user->is_verified == 1)  
                                                            <button class="btn btn-warning" data-toggle="modal" data-target="#resetPWModal-{{$k}}">Reset Password</button>
                                                            <!-- resetPW -->
                                                            <div class="modal fade" id="resetPWModal-{{$k}}" tabindex="-1" role="dialog">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title" id="defaultModalLabel">Reset Password !!!</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Are you sure you want to reset password for {{$user->name}}?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <a href="{{route('reset-client-password',$user->id)}}" class="btn btn-info">Yes, Reset </a>
                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{$agent_title}}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="justify-content-center">
                                                    <ul class="pagination">
                                                        {!! $users->render() !!}
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
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endsection