<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="keywords" content="@if(isset($meta_keywords)){{$meta_keywords}}@else{{SITE_META_KEYWORDS}}@endif">
    <meta name="description" content="@if(isset($meta_keywords)){{$meta_keywords}}@else{{SITE_META_DESCRIPTION}}@endif">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @isset($pagetitle) {{ $pagetitle }} | {{ SITE_TITLE }} @else {{ SITE_TITLE }} @endisset </title>

    {{--<link rel="manifest" href="site.html">--}}
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('resources/front-end/images/favicon.png')}}">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="{{asset('resources/front-end/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('resources/front-end/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('resources/front-end/css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('resources/front-end/css/meanmenu.css')}}">
    <link rel="stylesheet" href="{{asset('resources/front-end/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('resources/front-end/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('resources/front-end/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('resources/front-end/css/default.css')}}">
    <link rel="stylesheet" href="{{asset('resources/front-end/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('resources/front-end/css/responsive.css')}}">
</head>
