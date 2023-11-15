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
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-3">Commissions</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="m-b-20">
                                                <div class="table-responsive m-t-20">
                                                    <table class="table m-b-0 f-14 b-solid requid-table table-hover">
                                                        <thead>
                                                        <tr class="text-uppercase">
                                                            <th class="text-center">S.N#</th>
                                                            <th class="text-center">Product</th>
                                                            <th class="text-center">Commission per bottle</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="text-center text-muted">
                                                        @foreach($agentCommissions as $k=>$commission)
                                                        <tr>
                                                            <td>{{$k + 1}}.</td>
                                                            <td>
                                                                <div class="image-trap">
                                                                    <a href="{{asset('uploads/Product/thumbnail/'.$commission->product->image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class=" img-responsive">
                                                                        <img class="" style="width:70px;" src="{{asset('uploads/Product/thumbnail/'.$commission->product->image)}}" alt="No Image">
                                                                        <div class="g-title">
                                                                            <i class="fa fa-search"></i>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                                <span>&nbsp;&nbsp;{{$commission->product->title}}</span>
                                                            </td>
                                                            <td>${{$commission->price_per_bottle}}</td>
                                                        </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

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
            $('form').parsley();
        });
        $('.setCommission').repeater({
            show: function () {
                $(this).slideDown();
            },
            hide: function (deleteElement) {
                if(confirm('Are you sure you want to delete this element?')) {
                }
                $(this).slideUp(deleteElement);
            },
            ready: function (setIndexes) {

            }
        });

    </script>
@endsection