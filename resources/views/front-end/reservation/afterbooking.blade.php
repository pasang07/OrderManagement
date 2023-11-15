@extends('layouts.super-admin.layouts')
@section('content')
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <!-- [ breadcrumb ] start -->
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">Booking Details</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('reservation.index')}}">All Bookings</a></li>
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
                                <div class="col-md-12 invoice-btn-group text-right m-b-15">
                                    <button type="button" class="btn btn-secondary btn-print-invoice m-b-10"><i class="fas fa-print"></i> Print Details</button>
                                </div>
                                <!-- [ Invoice ] start -->
                                <div class="container-fluid" id="printTable">
                                    <div>
                                        <div class="card">
                                            {{--<div class="row invoice-contact">--}}
                                            {{--<div class="col-md-8">--}}
                                            {{--<div class="invoice-box row">--}}
                                            {{--<div class="col-sm-12">--}}
                                            {{--<table class="table table-responsive invoice-table table-borderless">--}}
                                            {{--<tbody>--}}
                                            {{--<tr>--}}
                                            {{--<td><img src="{{asset('resources/front-end/images/logo.png')}}" class="m-b-10" alt=""></td>--}}
                                            {{--</tr>--}}
                                            {{--<tr>--}}
                                            {{--<td>{{$site_data->title}}</td>--}}
                                            {{--</tr>--}}
                                            {{--<tr>--}}
                                            {{--<td><a class="text-secondary" href="mailto:{{$site_data->email}}" target="_top">{{$site_data->email}}</a></td>--}}
                                            {{--</tr>--}}
                                            {{--</tbody>--}}
                                            {{--</table>--}}
                                            {{--</div>--}}
                                            {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-md-4"></div>--}}
                                            {{--</div>--}}
                                            <div class="card-block">
                                                <div class="row invoive-info">
                                                    <div class="col-md-4 col-xs-12 invoice-client-info">
                                                        <h6>Customer Information :</h6>
                                                        <p class="m-0">{{$reservation->name}}</p>
                                                        <p class="m-0 m-t-10">{{$reservation->country}}</p>
                                                        <p class="m-0">{{$reservation->phone}}</p>
                                                        <p><a class="text-secondary" href="mailto:{{$reservation->email}}" target="_top">{{$reservation->email}}</a></p>
                                                    </div>
                                                    <div class="col-md-5 col-sm-6">
                                                        <h6>Booking Information :</h6>
                                                        <table class="table table-responsive invoice-table invoice-order table-borderless">
                                                            <tbody>
                                                            <tr>
                                                                <th>Check In:</th>
                                                                <td>{{$reservation->check_in_date}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Check Out:</th>
                                                                <td>{{$reservation->check_out_date}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Status :</th>
                                                                <td>
                                                                    <span class="label label-warning">Pending</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Id :</th>
                                                                <td>
                                                                    #146859
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-3 col-sm-6">
                                                        <h6 class="m-b-20">Invoice Number <span>#123685479624</span></h6>
                                                        <h6 class="text-uppercase text-primary">Total Due :
                                                            <span>$950.00</span>
                                                        </h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table  invoice-detail-table">
                                                                <thead>
                                                                <tr class="thead-default">
                                                                    <th>Description</th>
                                                                    <th>Quantity</th>
                                                                    <th>Amount</th>
                                                                    <th>Total</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <h6>Logo Design</h6>
                                                                        <p>lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt </p>
                                                                    </td>
                                                                    <td>6</td>
                                                                    <td>$200.00</td>
                                                                    <td>$1200.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <h6>Logo Design</h6>
                                                                        <p>lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt </p>
                                                                    </td>
                                                                    <td>7</td>
                                                                    <td>$100.00</td>
                                                                    <td>$700.00</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <h6>Logo Design</h6>
                                                                        <p>lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt </p>
                                                                    </td>
                                                                    <td>5</td>
                                                                    <td>$150.00</td>
                                                                    <td>$750.00</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <table class="table table-responsive invoice-table invoice-total">
                                                            <tbody>
                                                            <tr>
                                                                <th>Sub Total :</th>
                                                                <td>$4725.00</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Taxes (10%) :</th>
                                                                <td>$57.00</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Discount (5%) :</th>
                                                                <td>$45.00</td>
                                                            </tr>
                                                            <tr class="text-info">
                                                                <td>
                                                                    <hr />
                                                                    <h5 class="text-primary m-r-10">Total :</h5>
                                                                </td>
                                                                <td>
                                                                    <hr />
                                                                    <h5 class="text-primary">$4827.00</h5>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <h6>Terms And Condition :</h6>
                                                        <p>lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                                            laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- [ Invoice ] end -->
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
@stop
@section('page-specific-scripts')
    <script>
        // print button
        function printData() {
            var divToPrint = document.getElementById("printTable");
            newWin = window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
        }

        $('.btn-print-invoice').on('click', function() {
            printData();
        })

    </script>
@endsection