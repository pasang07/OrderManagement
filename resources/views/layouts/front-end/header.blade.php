<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
<![endif]-->
<!-- header-start -->
<header>
    <div class="header-menu red-header">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3">
                    <div class="logo">
                        <a href="{{route('home.index')}}">
                            <img src="{{asset('uploads/Nav/thumbnail/'.$site_data->logo_image)}}" alt="No Logo" width="181" />
                        </a>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-9">
                    <div class="header-button d-none d-sm-none d-md-none d-lg-block">
                        <a class="btn red-btn" href="#">get a quote
                            <i class="fas fa-long-arrow-alt-right"></i>
                        </a>
                    </div>
                    <div class="main-menu text-center">
                        <nav id="mobile-menu">
                           <?php TreeHelper::$level = 0; TreeHelper::$result = null;  ?>
                            {!! TreeHelper::megaMenu(1, NULL,NULL,NULL)!!}
                            {{--<ul>--}}
                                {{--<li class="active">--}}
                                    {{--<a href="{{route('home.index')}}">Home</a>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="services.php">Services</a>--}}
                                    {{--<ul class="submenu">--}}
                                        {{--<li>--}}
                                            {{--<a href="service-detail.php">Service Detail</a>--}}
                                        {{--</li>--}}
                                    {{--</ul>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="blog.php">Blog</a>--}}
                                    {{--<ul class="submenu">--}}
                                        {{--<li>--}}
                                            {{--<a href="blog-details.php">Blog Details</a>--}}
                                        {{--</li>--}}
                                    {{--</ul>--}}
                                {{--</li>--}}
                                {{--<li>--}}
                                    {{--<a href="contact.php">Contact</a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        </nav>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="mobile-menu"></div>
            </div>
        </div>
    </div>
</header>
<!-- header-end -->