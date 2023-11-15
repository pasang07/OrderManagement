@extends('layouts.front-end.layouts', ['pagetitle'=> 'Gallery'])
@section('content')

    <section class="page-title" style="background: none; height: 200px;">
         <div class="page-title-container">
            <div class="page-title-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col col-xs-12">
                            <h2 style="font-size:2rem;">Our Gallery</h2>
                            <ol class="breadcrumbb">
                                <li><a href="{{route('home.index')}}">Home</a></li>
                                <li>Gallery</li>
                            </ol>
                        </div>
                    </div> <!-- end row -->
                </div> <!-- end container -->
            </div>
        </div>
        <div class="glass-effect2"></div>
    </section>

    <!-- start case-single-section -->
    <section class="case-single-section" style="padding-top: 0px;">
        <div class="container">
            <div class="row">
                <div class="col col-12">
                    <div class="case-single-area" style="padding-top: 0px;">
                        <div class="case-details">
                            <div id="gallery">
                                <div id="image-gallery">
                                    <div class="row">
                                        @foreach($galleries as $gallery)
                                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 image">
                                            <div class="img-wrapper">
                                                <a href="{{asset('uploads/Gallery/thumbnail/'.$gallery->image)}}"><img src="{{asset('uploads/Gallery/thumbnail/'.$gallery->image)}}" class="img-responsive"></a>
                                                <div class="img-overlay">
                                                    <i class="pe-7s-photo" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div><!-- End row -->
                                         <div class="col col-xs-12" style="float: right;margin-top: 30px;">
                        <ul>
                            {!! $galleries->render() !!}
                        </ul>
                    </div>
                                </div><!-- End image gallery -->
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
    <script src="{{asset('resources/front-end/assets/js/gallery.js')}}"></script>

@endsection