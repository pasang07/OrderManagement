@if(Auth::user()->is_new == 'no')
<?php
function current_page($url = "/"){
    return strstr(request()->path(), $url);
}
?>
<body class="box-layout" id="style-5">
<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>
<!-- [ Pre-loader ] End -->

<!-- [ navigation menu ] start -->
<nav class="pcoded-navbar navbar-collapsed">
    <div class="navbar-wrapper">
        <div class="navbar-brand header-logo">
            <a href="{{route('superadmin.dashboard')}}" class="b-brand">
                <!--<div class="b-bg">-->
                <!--    <i class="fas fa-user"></i>-->
                <!--</div>-->
                <!--<span class="b-title">{{SITE_TITLE}}</span>-->
                @if($site_data->logo_image)
                <img src="{{asset('uploads/Nav/thumbnail/'.$site_data->logo_image)}}" style="width: 130px;">
                @else
                <img src="{{asset('resources/super-admin/images/order_portal_logo.png')}}" style="width: 130px;">
                @endif
            </a>
            <a class="mobile-menu" id="mobile-collapse" href="javascript:"><span></span></a>
        </div>
        <div class="navbar-content scroll-div">
            <ul class="nav pcoded-inner-navbar">
                <li class="nav-item pcoded-menu-caption">
                    <label>- BY POCKET STUDIO</label>
                </li>
                <li data-username="icons Feather Fontawsome flag material simple line themify"  class="{{ (current_page('super-admin/dashboard')) ? 'nav-item active pcoded-trigger' : '' }}">
                    <a href="{{route('superadmin.dashboard')}}" class="nav-link"><span class="pcoded-micon"><i class="icon fas fa-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
                </li>
                @if(Auth::user()->role=='superadmin' || Auth::user()->role=='admin' || Auth::user()->role=='demo')
                    <li data-username="Gallery Grid Masonry Advance" class="nav-item pcoded-hasmenu">
                        <a href="javascript:" class="nav-link"><span class="pcoded-micon"><i class="fa fa-users-cog"></i></span><span class="pcoded-mtext">User Setup</span></a>
                        <ul class="pcoded-submenu">
                            @if(Auth::user()->role=='admin')
                            <li class=""><a href="{{route('user.index')}}" class="">Admin</a></li>
                            @endif
                            <li class=""><a href="{{route('client.index')}}" class="">Customer</a></li>
                            <li class=""><a href="{{route('agent.index')}}" class="">Agent</a></li>
                        </ul>
                    </li>
                    <li data-username="icons Feather Fontawsome flag material simple line themify"  class="{{ (current_page('admin-refer-customer')) ? 'nav-item active pcoded-trigger' : '' }}">
                        <a href="{{route('admin-refer-customer.index')}}" class="nav-link"><span class="pcoded-micon"><i class="icon fas fa-user-friends"></i></span><span class="pcoded-mtext">Requested Customer</span>@if(TreeHelper::request_customer_count() > 0)<span class="pcoded-badge label label-danger">{!! TreeHelper::request_customer_count() !!}</span>@endif</a>
                    </li>
                    <li data-username="icons Feather Fontawsome flag material simple line themify"  class="{{ (current_page('agent-commission')) ? 'nav-item active pcoded-trigger' : '' }}">
                        <a href="{{route('agent-commission.index')}}" class="nav-link"><span class="pcoded-micon"><i class="icon fas fa-money-bill"></i></span><span class="pcoded-mtext">Commissions</span></a>
                    </li>
                    <li data-username="Gallery Grid Masonry Advance" class="nav-item pcoded-hasmenu">
                        <a href="javascript:" class="nav-link"><span class="pcoded-micon"><i class="fa fa-bullseye"></i></span><span class="pcoded-mtext">Product Setup</span></a>
                        <ul class="pcoded-submenu">
                            <li><a href="{{route('product.index')}}">Product List</a></li>
                            <li><a href="{{route('moq.create')}}">Set MOQ</a></li>
                            <li><a href="{{route('moq.index')}}">All MOQs</a></li>
                        </ul>
                    </li>
                    <li data-username="icons Feather Fontawsome flag material simple line themify"  class="{{ (current_page('order-query')) ? 'nav-item active pcoded-trigger' : '' }}">
                        <a href="{{route('order-query.index')}}" class="nav-link"><span class="pcoded-micon"><i class="icon fas fa-shopping-cart"></i></span><span class="pcoded-mtext">Order Summary</span></a>
                    </li>
                    <li data-username="icons Feather Fontawsome flag material simple line themify"  class="{{ (current_page('site-setting/1/edit')) ? 'nav-item active pcoded-trigger' : '' }}">
                        <a href="{{route('site-setting.edit',1)}}" class="nav-link"><span class="pcoded-micon"><i class="icon fas fa-cog"></i></span><span class="pcoded-mtext">Settings</span></a>
                    </li>
                @endif
                @if(Auth::user()->role=='others')


                    <li data-username="Gallery Grid Masonry Advance" class="nav-item pcoded-hasmenu">
                        <a href="javascript:" class="nav-link"><span class="pcoded-micon"><i class="fas fa-shopping-cart"></i></span><span class="pcoded-mtext">Order Setup</span></a>
                        <ul class="pcoded-submenu">
                            <li><a href="{{route('place-order')}}">Place Order</a></li>
                            <li><a href="{{route('order-list.index')}}">Order History</a></li>
                        </ul>
                    </li>

                @endif
                @if(Auth::user()->role=='agent')
                    {{--<li data-username="profile " class="{{ (current_page('user/profile-setting/'.Auth::user()->id)) ? 'nav-item active pcoded-trigger' : '' }}">--}}
                        {{--<a href="{{route('user.profile-setting-form',Auth::user()->id)}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-user-cog"></i></span><span class="pcoded-mtext">Profile Setting</span></a>--}}
                    {{--</li>--}}
                    {{--<li data-username="Gallery Grid Masonry Advance" class="nav-item pcoded-hasmenu">--}}
                        {{--<a href="javascript:" class="nav-link"><span class="pcoded-micon"><i class="fas fa-shopping-cart"></i></span><span class="pcoded-mtext">Customer List</span></a>--}}
                        {{--<ul class="pcoded-submenu">--}}
                            {{--<li><a href="{{route('refer-customer.create')}}">Refer / Request Customer</a></li>--}}
                            {{--<li><a href="{{route('refer-customer.index')}}">Customer List</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    <li data-username="refer-customer " class="{{ (current_page('refer-customer')) ? 'nav-item active pcoded-trigger' : '' }}">
                        <a href="{{route('refer-customer.index')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-user-cog"></i></span><span class="pcoded-mtext">Refer Customer</span></a>
                    </li>
                    <li data-username="commission" class="{{ (current_page('view-commission')) ? 'nav-item active pcoded-trigger' : '' }}">
                        <a href="{{route('view-commission.index', Auth::user()->id)}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-money-bill"></i></span><span class="pcoded-mtext">Your Commissions</span></a>
                    </li>
                    <li data-username="commission" class="{{ (current_page('commission-lists')) ? 'nav-item active pcoded-trigger' : '' }}">
                        <a href="{{route('commission-list.index')}}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-file-alt"></i></span><span class="pcoded-mtext">Summary Report</span></a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<!-- [ navigation menu ] end -->
@endif
