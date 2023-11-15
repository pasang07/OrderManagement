@extends('layouts.front-end.layouts', ['pagetitle'=> $model->title])
@section('content')
    <section class="page-title" style="background: none; height: 0;">
        <div class="glass-effect2"></div>
    </section>
    <!-- start service-single-section -->
    <section class="service-single-section section-padding">
        <div class="container">
            <div class="row">
                <div class="glass-effect2"></div>
                <div class="col col-xl-9 col-12 order-last">

                    <div class="service-single-content">
                        @if($model->video_url)
                        <iframe width="100%" class="serv_video" src="{{$model->video_url}}?autoplay=1"></iframe>
                        @else
                        <div class="service-pic">
                            <img src="{{asset('uploads/Software/thumbnail/'.$model->image)}}" alt>
                        </div>
                        @endif
                        <h2>{{$model->title}}</h2>
                        <div class="text-justify">
                            {!! $model->overview !!}
                        </div>
                        @if($model->useage)
                        <h4>Usage</h4>
                        <div class="service-features">
                           {!! $model->useage !!}
                        </div>
                        @endif
                        
                       @if($model->amc)
                       <div class="service-single-tab">
                            <ul class="nav" id="pills-tab" role="tablist">
                                <li>
                                    <button class="active" id="pills-amc-tab" data-bs-toggle="pill" data-bs-target="#pills-amc">Annual Maintainance Cost</button>
                                </li>
                                {{--<li>--}}
                                    {{--<button id="pills-useage-tab" data-bs-toggle="pill" data-bs-target="#pills-useage">Intelligence</button>--}}
                                {{--</li>--}}
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-amc">
                                    {!! $model->amc !!}
                                </div>
                                <div class="tab-pane fade" id="pills-useage">A collection of textile samples lay spread out on the table smsa was a travelling salesman and above it there hung picture that he had recently cut out of an illustrated magazine and housed in a nice, gilded frame. It showed a lady fitted out with a fur hat and fur boa who sat upright, raising a heavy fur muff that covered the whole of her lower arm towards the viewer. Gregor then turned to look out the window at the dull weather
                                </div>
                            </div>
                        </div>
                       @endif
                        <div class="request-service">
                            <h3>Request this software</h3>
                            <form method="post" action="{{route('software.request')}}">
                                @csrf
                                <input type="hidden" class="form-control"  name="software_id" value="{{$model->id}}" readonly>

                                <div id="quoteButton">
                                    <label for="quote" style="font-size: 16px;font-weight: bold;letter-spacing: 0.6px;padding: 10px;"><i class="pe-7s-cash"></i> Quote</label>
                                    <input type="checkbox" class="check" name="quote" id="quote" style="width: 50%;height: 20px;" value="yes_quote">
                                </div>
                                <div id="quoteButton">
                                    <label for="demo" style="font-size: 16px;font-weight: bold;letter-spacing: 0.6px;padding: 10px;"><i class="pe-7s-news-paper"></i> Demo</label>
                                    <input type="checkbox" class="check" name="demo" id="demo" style="width: 50%;height: 20px;" value="yes_demo">
                                </div>
                                <div id="quoteButton">
                                    <label for="info" style="font-size: 16px;font-weight: bold;letter-spacing: 0.6px;padding: 10px;"><i class="pe-7s-info"></i> Info</label>
                                    <input type="checkbox" class="check" name="info" id="info" style="width: 50%;height: 20px;" value="yes_info">
                                </div>
                                <div>
                                    <input type="text" class="form-control"  name="software_name" value="{{$model->title}}" readonly>
                                </div>
                                <div>
                                    <input type="text" class="form-control"  name="name" id="name" placeholder="Your Name*">
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                </div>
                                <div>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Your Email*">
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                </div>
                                <div>
                                    <input type="text" class="form-control"  name="phone" id="phone" placeholder="Your Phone*">
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                </div>
                                <div class="submit-area">
                                    <button type="submit">Request Now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col col-xl-3 order-fast">
                    <div class="service-sidebar">
                        <div class="widget service-list-widget">
                            <h4>Softwares</h4>
                            <?php TreeHelper::$level = 0; TreeHelper::$result = null;  ?>
                            {!! TreeHelper::serviceMenu(20, NULL,NULL,NULL)!!}
                        </div>
                        <div class="widget contact-widget" style="background: #000;">
                            <div>
                                <h4>Subscription</h4>
                                <p>Get this software and more on Pocket Studio Subscription</p>
                                <a href="{{route('contact-us.index')}}">Contact Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end service-single-section -->
@stop
@section('page-specific-scripts')

@endsection