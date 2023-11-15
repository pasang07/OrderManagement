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
                        <div class="service-pic">
                            <img src="{{asset('uploads/Amenity/thumbnail/'.$model->image)}}" alt>
                        </div>
                        <h2>{{$model->title}}</h2>
                        <div class="text-justify">
                            {!! $model->content !!}
                        </div>
                        @if($model->amenity_faqs->count()>0)
                        <h4>FAQ</h4>
                        <div id="accordion" class="accordion">
                            <div class="card mb-0" style="background: transparent; border:0;">
                               @foreach($model->amenity_faqs as $f=>$faq)
                                <div class="card-header collapsed" data-toggle="collapse" href="#collapse{{$f}}" style="border-bottom: 1px solid #4d4d4d63;">
                                    <a class="card-title">
                                        {{$faq->question}}
                                    </a>
                                </div>
                                <div id="collapse{{$f}}" class="card-body collapse" data-parent="#accordion" >
                                    <p>
                                        {{$faq->answer}}
                                    </p>
                                </div>
                               @endforeach
                            </div>
                        </div>
                        @endif
                        <div class="request-service">
                            <h3>Request this service</h3>
                            <form method="post" action="{{route('service.request')}}">
                                @csrf
                                <input type="hidden" class="form-control"  name="service_id" value="{{$model->id}}" readonly>
                                <div id="quoteButton" class="col-6">
                                    <label for="quote" style="font-size: 16px;font-weight: bold;letter-spacing: 0.6px;padding: 10px;"><i class="pe-7s-cash"></i> Quote</label>
                                    <input type="checkbox" class="check" name="quote" id="quote" style="width: 50%;height: 20px;" value="yes_quote">
                                </div>

                                <div id="quoteButton" class="col-6">
                                    <label for="info" style="font-size: 16px;font-weight: bold;letter-spacing: 0.6px;padding: 10px;"><i class="pe-7s-info"></i> Info</label>
                                    <input type="checkbox" class="check" name="info" id="info" style="width: 50%;height: 20px;" value="yes_info">
                                </div>
                                <div>
                                    <input type="text" class="form-control"  name="service_name" value="{{$model->title}}" readonly>
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
                            <h4>Services</h4>
                            <?php TreeHelper::$level = 0; TreeHelper::$result = null;  ?>
                            {!! TreeHelper::serviceMenu(5, NULL,NULL,NULL)!!}
                        </div>
                        {{--<div class="widget contact-widget">--}}
                            {{--<div>--}}
                                {{--<h4>Have any query?</h4>--}}
                                {{--<p>Dovered the whole of her lower arm towards the viewer.</p>--}}
                                {{--<a href="#">Contact now</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end service-single-section -->
@stop
@section('page-specific-scripts')
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
@endsection