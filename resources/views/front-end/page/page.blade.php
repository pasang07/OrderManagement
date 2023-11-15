@extends('layouts.front-end.layouts', ['pagetitle'=> $model->title])
@section('content')
    <section class="page-title" style="background: none; height: 0;">
        <div class="glass-effect2"></div>
    </section>

    <!-- start case-single-section -->
    <section class="case-single-section" style="padding-top: 0px;">
        <div class="container">
            <div class="row">
                <div class="col col-12">
                    <div class="case-single-area" style="padding-top: 0px;">
                        <div class="case-details">
                            <h2>{{$model->title}}</h2>
                            @if($model->image)
                            <div class="img-holder">
                                <img src="{{asset('uploads/Page/thumbnail/'.$model->image)}}" alt>
                            </div>
                            @endif
                            <div class="case-row clearfix text-justify">
                                {!! $model->content !!}
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end container -->
    </section>
    <!-- end case-single-section -->
@stop
@section('page-specific-scripts')
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
@endsection