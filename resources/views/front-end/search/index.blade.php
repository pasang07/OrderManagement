@extends('layouts.front-end.layouts', ['pagetitle'=> 'Search'])
@section('content')

    <div class="breadcrumbs">
        <div class="wrap">
            <div class="wrap_float">
                <a href="{{route('home.index')}}">Home</a>
                <span class="separator">/</span>
                <a href="#" class="current">Search Results</a>
            </div>
        </div>
    </div>
    <div class="image_bg--single" style="background-image: url({{asset('uploads/SEO/thumbnail/'.$model->image)}});"></div>
    <div class="page_content blog-page search-page">
        <div class="wrap">
            <div class="wrap_float">
                {{--<div class="title">--}}
                    {{--Search Results--}}
                {{--</div>--}}
                <div class="subtitle">
                    {{ $searchResults->count() }} results found for {{$key}}
                </div>
                <div class="main">
                    <div class="blog-list">
                        <?php
                        $i = 1;?>
                        @foreach($searchResults->groupByType() as $type => $modelSearchResults)
                            @foreach($modelSearchResults as $searchResult)
                        <a href="{{$searchResult->url}}" class="blog-item">
                            <div class="_title">{{$i}}. {{$searchResult->title}}</div>
                        </a>
                                    <?php $i++; ?>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('page-specific-scripts')

@endsection