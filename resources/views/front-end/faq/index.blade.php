@extends('layouts.front-end.layouts')
@section('content')
    <div class="tg-innerbanner tg-hasborder tg-haslayout">
        <div class="clearfix"></div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <ol class="tg-breadcrumb">
                        <li><a href="{{route('home.index')}}">home</a></li>
                        <li class="tg-active">Faq</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <main id="tg-main" class="tg-main tg-haslayout tg-paddingzero">
        <div class="tg-sectionspace tg-haslayout">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 colmd-12 col-lg-12">
                        <div class="tg-gallerymasnory">
                            <div id="tg-galleryfilterable" class="tg-galleryfilterable">
                                <div class="tg-shortcode tg-faqs">
                                    <div class="tg-title mt-25">
                                        <h2>FAQ ?</h2>
                                    </div>
                                    <div id="tg-accordion" class="tg-accordion" role="tablist" aria-multiselectable="true">
                                        @foreach($faqs as $faq)
                                            <div class="tg-panel">
                                                <h4><span>Q.</span>{{$faq->title}}</h4>
                                                <div class="tg-panelcontent">
                                                    <div class="tg-description">
                                                        <p><span>A.</span>{!! $faq->content !!}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop