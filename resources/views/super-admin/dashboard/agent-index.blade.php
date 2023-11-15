
<div class="col-md-12 col-xl-4">
    <div class="card Active-visitor">
        <div class="card-block text-center">
            <h5 class="mb-3">Total Customer this month</h5>
            <i class="fas fa-user-friends f-30 text-c-green"></i>
            <h2 class="f-w-300 mt-3">{{$monthwiseCustomer->count()}}</h2>

        </div>
    </div>
</div>

<div class="col-md-12 col-xl-4">
    <div class="card Active-visitor">
        <div class="card-block text-center">
            <h5 class="mb-3">Total Customer</h5>
            <i class="fas fa-user-friends f-30 text-c-green"></i>
            <h2 class="f-w-300 mt-3">{{$agentBroughtCustomer->count()}}</h2>
            <span class="text-muted">Active Customer in the system</span>
            <div class="progress mt-4 m-b-40">
                <div class="progress-bar progress-c-theme" role="progressbar" style="width: 100%; height:7px;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="row card-active">
                <div class="col-md-4">
                    <h4 class="text-info">{{$approveCustomer->count()}}</h4>
                    <span class="text-info">Approved</span>
                </div>
                <div class="col-md-4">
                    <h4 class="text-warning">{{$referedCustomer->count()}}</h4>
                    <span class="text-warning">Requested</span>
                </div>
                <div class="col-md-4">
                    <h4 class="text-danger">{{$inactiveCustomer->count()}}</h4>
                    <span class="text-danger">Inactive</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{--<div class="col-md-6 col-xl-4">--}}
    {{--<div class="card Active-visitor">--}}
        {{--<div class="card-block text-center">--}}
            {{--<h5 class="mb-3">Total Purchased Order</h5>--}}
            {{--<i class="fas fa-shopping-cart f-30 text-c-green"></i>--}}
            {{--<h2 class="f-w-300 mt-3">0</h2>--}}

        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}

<div class="col-md-12 col-xl-4">
    <div class="card">
        <div class="card-header">
            <h5>Total Commissions</h5>
        </div>
        <div class="card-block">
            <div class="row align-items-center justify-content-center">
                <div class="col-9">
                    <h3 class="f-w-300 mb-0 float-left">{{$site_data->currency_format}} {{number_format($commissions)}}</h3>
                </div>
                <div class="col-3">
                    <img class="img-female" src="{{asset('resources/super-admin/images/user/chartflow.png')}}" alt="no image" width="80">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="@if(count($adminNotifications)>0) col-xl-8 col-md-12 @else col-md-12 @endif">
    <div class="card user-list">
        <div class="card-header">
            <h5>Products</h5>
        </div>
        <div class="card-block pb-0">
            <div class="table-responsive db-admin-view" id="orderMOQscroll">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Commission</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($agentCommissions as $k=>$agentCommission)
                        <tr id="{{$agentCommission->id}}">
                            <td>{{$k+1}}</td>
                            <td>
                                <div class="image-trap">
                                    <a href="{{asset('uploads/Product/thumbnail/'.$agentCommission->product->image)}}" data-toggle="lightbox" data-gallery="multiimages" data-title="" class=" img-responsive">
                                        <img class="" style="width:70px;" src="{{asset('uploads/Product/thumbnail/'.$agentCommission->product->image)}}" alt="No Image">
                                        <div class="g-title">
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <h6 class="mb-1">{{$agentCommission->product->title}}</h6>
                            </td>
                            <td>
                                <h6 class="mb-1">${{$agentCommission->price_per_bottle}}</h6>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if($agentCommissions->count() == 3)
        <div class="card-footer text-center">
            <a href="{{route('view-commission.index', Auth::user()->id)}}" class="btn btn-outline-dark">VIEW ALL</a>
        </div>
        @endif
    </div>
</div>

@if(count($adminNotifications)>0)
    <div class="col-xl-4 col-md-12">
        <div class="card note-bar">
            <div class="card-header">
                <h5>Notifications</h5>
            </div>
            <div class="card-block p-0">
                @foreach($adminNotifications as $notification)
                    <a href="#!" class="media friendlist-box">
                        <div class="mr-3 photo-table">
                            <i class="far fa-bell f-30"></i>
                        </div>
                        <div class="media-body">
                            <h6>{{$notification->data['type']}}</h6>
                            <span class="f-12 float-right text-muted">{{date('d M, Y', strtotime($notification->created_at))}}</span>
                            <p class="text-muted m-0">{{$notification->data['text']}}</p>
                        </div>
                    </a>

                @endforeach
            </div>
        </div>
    </div>
@endif