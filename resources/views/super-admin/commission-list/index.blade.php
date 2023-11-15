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
                                        <li class="breadcrumb-item"><a href="javascript:">Commission</a></li>
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
                                            <h5>Commission</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table id="sortable" class="table table-hover todo-list ui-sortable">
                                                    <thead>
                                                        <tr>
                                                            <th>S.N.</th>
                                                            <th>Order No</th>
                                                            <th>Customer Details</th>
                                                            <th>Total Commission {{$site_data->currency_format}}</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($commissionLists as $k=>$commissionList)
                                                       <?php
                                                       $amountReceived = \App\Models\Model\SuperAdmin\Commission\Commission::where('order_no', $commissionList->order_no)->get()->sum('amount');
                                                       $totalCommissions = \App\Models\Model\SuperAdmin\Commission\Commission::where('order_no', $commissionList->order_no)->get();
                                                       $totalOrders = \App\Models\Model\SuperAdmin\OrderList\OrderList::where('order_no',$commissionList->order_no)->where('is_confirm', 'yes')->where('is_approve', 'yes')->get();
                                                       $leftCommission = count($totalOrders) - count($totalCommissions);
                                                       ?>
                                                    <tr id="{{$commissionList->id}}">
                                                        <td>{{$k+1}}</td>
                                                        <td>
                                                            <h6 class="mb-1"> #{{$commissionList->order_no}}</h6>
                                                            Commission Received At:  {{date('d M, Y', strtotime($commissionList->received_date))}}
                                                        </td>
                                                        <td>
                                                            <span style="font-weight: 800;"> {{$commissionList->customer->name}}</span>
                                                            @if($commissionList->customer->email)
                                                                <br> <a href="mailto:{{$commissionList->customer->email}}">
                                                                    {{$commissionList->customer->email}}
                                                                </a>
                                                            @endif
                                                            @if($commissionList->customer->phone)
                                                                <br> {{$commissionList->customer->phone}}
                                                            @endif
                                                            @if($commissionList->customer->address)
                                                                <br> {{$commissionList->customer->address}}
                                                            @endif

                                                        </td>
                                                        <td>
                                                            {{number_format($amountReceived)}}
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#commissionDetail-{{$k}}">Summary</button>
                                                            <!-- commissionDetail -->
                                                            <div class="modal fade" id="commissionDetail-{{$k}}" tabindex="-1" role="dialog">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title" id="defaultModalLabel">Commission Summary of - {{date('d M, Y', strtotime($commissionList->received_date))}}</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="row">
                                                                                <table class="table">
                                                                                    <thead><tr><th>S.N</th><th>Product</th><th>Qty</th><th>Amount {{$site_data->currency_format}}</th></tr></thead>
                                                                                    <tbody>
                                                                                    @foreach($totalCommissions as $t=>$details)
                                                                                        <tr>
                                                                                            <td>{{$t+1}}.</td>
                                                                                            <td>{{$details->product->title }}</td>
                                                                                            <td>{{$details->qty}}</td>
                                                                                            <td>{{$details->amount}}</td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                    <tr>
                                                                                        <td></td>
                                                                                        <td></td>
                                                                                        <td><h5>Total: </h5></td>
                                                                                        <td><h5> ${{number_format($amountReceived)}} </h5></td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        {{--<td>--}}
                                                            {{--@if($leftCommission > 0)--}}
                                                            {{--<p>--}}
                                                                {{--Out of {{$totalOrders->count()}} orders, {{$leftCommission}} order is not assign in your commission list.--}}
                                                            {{--</p>--}}
                                                            {{--@endif--}}
                                                        {{--</td>--}}
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
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