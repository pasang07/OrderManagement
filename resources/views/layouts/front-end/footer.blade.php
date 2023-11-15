<!-- footer-start -->
<footer class="black-bg">
    <div class="footer-top-area pt-80 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-3 col-md-6 col-sm-12">
                    <div class="footer-wrapper footer-wrapper-2 mb-20 pr-30">
                        <a href="{{route('home.index')}}">
                            <img src="{{asset('uploads/Nav/thumbnail/'.$site_data->footer_logo_image)}}" alt="No Logo" style="width: 250px;">
                        </a>
                        {{--<h3 class="footer-title">About us</h3>--}}
                        {{--<div class="footer-text">--}}
                        {{--<br>--}}
                        {{--<p>--}}
                        {{--Sorem ipsum dolor sit amet consadip eisicing elsed do eiusmod tempor incididunt labore etdolo magna aliqua. Ut enim ad minim--}}
                        {{--veniam quis--}}
                        {{--</p>--}}
                        {{--</div>--}}
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12">
                    <div class="footer-wrapper footer-wrapper-2 mb-30">
                        <h3 class="footer-title">Quick Links</h3>
                        <?php TreeHelper::$level = 0;
                        TreeHelper::$result = null; ?>
                        {!! TreeHelper::quickLinkMenu(2, NULL, 'footer-menu') !!}
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                    <div class="footer-wrapper footer-wrapper-2 mb-30">
                        <h3 class="footer-title">Contact</h3>
                        <ul class="footer-menu">
                            <li><a href="#"><i class="fa fa-map-marker-alt"></i> &nbsp;{{$site_data->address}}</a></li>
                            @if($site_data->tel_no)
                                <li><a href="tel:{{$site_data->tel_no}}"><i class="fa fa-phone"></i> &nbsp;{{$site_data->tel_no}}</a></li>
                            @endif
                            @if($site_data->mobile_no)
                                <li><a href="tel:{{$site_data->mobile_no}}"><i class="fa fa-mobile"></i> &nbsp;{{$site_data->mobile_no}}</a></li>
                            @endif
                            <li><a href="mailto:{{$site_data->email}}"><i class="fa fa-envelope"></i> &nbsp;{{$site_data->email}}</a>
                                @if($site_data->email_2)
                                    , <a href="mailto:{{$site_data->email_2}}">{{$site_data->email_2}}</a>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                    <div class="footer-wrapper footer-wrapper-2 mb-30">
                        <h3 class="footer-title">Visit Our Office</h3>
                        <div class="footer-text">
                            <p>{{$site_data->open_time}} or Talk to an Expert @if($site_data->tel_no) <a href="tel:{{$site_data->tel_no}}" class="text-white"> {{$site_data->tel_no}}</a> @endif @if($site_data->tel_no) <a href="tel:{{$site_data->mobile_no}}" class="text-white"> / {{$site_data->mobile_no}}</a> @endif, Available 24*7.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom-area copyright-border pt-20 pb-20">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="copyright text-center">
                        <p>Copyright
                            <i class="far fa-copyright"></i>  {{date('Y')}} {{SITE_TITLE}}. All Rights Reserved</p>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="footer-copyright-icon text-center text-md-right">
                        @if($site_data->facebook)<a href="{{$site_data->facebook}}" target="_blank"><i class="fab fa-facebook"></i></a>@endif
                        @if($site_data->twitter)<a href="{{$site_data->twitter}}" target="_blank" ><i class="fab fa-twitter"></i></a>@endif
                        @if($site_data->instagram)<a href="{{$site_data->instagram}}" target="_blank"><i class="fab fa-instagram"></i></a>@endif
                        @if($site_data->youtube) <a href="{{$site_data->youtube}}" target="_blank" ><i class="fab fa-youtube"></i> </a>@endif
                        @if($site_data->linkedin) <a href="{{$site_data->linkedin}}" target="_blank" ><i class="fab fa-linkedin"></i></a>@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer-end -->

<!-- JS here -->
<script src="{{asset('resources/front-end/js/vendor/modernizr-3.5.0.min.js')}}"></script>
<script src="{{asset('resources/front-end/js/vendor/jquery-1.12.4.min.js')}}"></script>
<script src="{{asset('resources/front-end/js/popper.min.js')}}"></script>
<script src="{{asset('resources/front-end/js/bootstrap.min.js')}}"></script>
<script src="{{asset('resources/front-end/js/jquery.meanmenu.js')}}"></script>
<script src="{{asset('resources/front-end/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('resources/front-end/js/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('resources/front-end/js/waypoints.min.js')}}"></script>
<script src="{{asset('resources/front-end/js/jquery.nice-select.min.js')}}"></script>
<script src="{{asset('resources/front-end/js/jquery.counterup.min.js')}}"></script>
<script src="{{asset('resources/front-end/js/slick.min.js')}}"></script>
<script src="{{asset('resources/front-end/js/ajax-form.js')}}"></script>
<script src="{{asset('resources/front-end/js/jquery.easypiechart.min.js')}}"></script>
<script src="{{asset('resources/front-end/js/wow.min.js')}}"></script>
<script src="{{asset('resources/front-end/js/jquery.scrollUp.min.js')}}"></script>
<script src="{{asset('resources/front-end/js/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{asset('resources/front-end/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('resources/front-end/js/plugins.js')}}"></script>
<script src="{{asset('resources/front-end/js/main.js')}}"></script>
<script src="{{asset('resources/front-end/js/scroll_down.js')}}"></script>

<script src="{{asset('js/sweetalert.min.js')}}"></script>
@if(session()->has('messages'))
    <script>
        swal("Success","{!!  session()->get('messages') !!}","success",{
            button: "OK",
        });
    </script>
@endif


@yield('page-specific-scripts')