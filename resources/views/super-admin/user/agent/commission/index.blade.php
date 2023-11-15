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
                                        <li class="breadcrumb-item"><a href="javascript:">Agent</a></li>
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
                                            <h5>Agent List</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table id="sortable" class="table table-hover todo-list ui-sortable">
                                                    <thead>
                                                        <tr>
                                                            <th>S.N.</th>
                                                            <th>Agent</th>
                                                            <th>Commission</th>
                                                            <th>Summary Report</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($agentLists as $k=>$agentList)
                                                    <tr id="{{$agentList->id}}">
                                                        <td>{{$k+1}}</td>
                                                        <td>
                                                            <h6 class="mb-1">{{$agentList->name}}</h6>
                                                        </td>
                                                        <td>
                                                            @if($agentList->is_verified == 1)
                                                            <a href="{{route('manage-commission.index', $agentList->id)}}"><button type="button" class="btn btn-info">Set / Manage</button></a>
                                                            @else
                                                            <h6 class="text-danger">This agent is not verified.</h6>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($agentList->is_verified == 1)
                                                                <a href="{{route('agent-wise-commission', $agentList->id)}}"><button type="button" class="btn btn-icon btn-outline-dark"><i class="fa fa-file-alt"></i></button></a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="justify-content-center">
                                                    <ul class="pagination">
                                                        {!! $agentLists->render() !!}
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