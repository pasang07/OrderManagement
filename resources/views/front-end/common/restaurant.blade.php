<section id="banner-6" class="bg-fixed wide-100 banner-section division homeviewrests" style="background: #DFA839;">
    <div class="container">
        <div class="row d-flex">
            <!-- BANNER TEXT -->
            <div class="col-md-9 text-white">
                <div class="banner-5-txt text-white">
                    <!-- Title -->
                    <h3 class="h3-xl txt-color-01 text-white">{{$site_data->restaurant_title}}
                    </h3>
                    <p class=" text-white txt-color-01" style="padding: 10px 0;">
                        {{$site_data->restaurant_content}}
                    </p>
                    <div class="mt-10 mb-10">
                        <!-- Button -->
                        <a href="{{route('all.menus')}}" class="btn btn-sm btn-color-09">View Menu</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <img src="{{asset('uploads/Nav/thumbnail/'.$site_data->restaurant_image)}}">
            </div>
            <!-- END BANNER TEXT -->
        </div>
        <!-- End row -->
    </div>
    <!-- End container -->
</section>