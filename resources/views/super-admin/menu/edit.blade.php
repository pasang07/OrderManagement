@extends('layouts.super-admin.layouts')
@section('page-specific-css')
    <!-- Bootstrap Select Css -->
@stop
@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <!-- [ breadcrumb ] start -->
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">Edit Menu</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}"><i class="feather icon-home"></i></a></li>
                                        <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{route('nav.index')}}">Menu</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">Edit Menu</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="{{route('nav.update',$nav->id)}}" enctype="multipart/form-data" autocomplete="off" data-parsley-validate>
                        {!! csrf_field() !!}
                        @include('super-admin.menu.form')
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('page-specific-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('form').parsley();
            document.getElementById('url_section').style.display = 'none';
        });
    </script>
    <script type="text/javascript">
        function changeType(type) {
            if (type == 'none' || type == 'link' || type == 'pages' || type == 'software' ||  type == 'amenities' || type == 'route')
            {
                document.getElementById('title_section').style.display = 'inline';
                if (type == 'none' ||type == 'pages'||type == 'software' ||type == 'amenities' || type == 'route')
                {
                    document.getElementById('url_section').style.display = 'none';
                } else if (type == 'link')
                {
                    document.getElementById('url_section').style.display = 'inline'
                }
            }else
            {
                document.getElementById('url_section').style.display = 'none';
                document.getElementById('page_section').style.display = 'none';
            }
            $.ajax({
                method: 'POST',
                url: '{{ route('nav.change-type-update') }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    type: type,
                },
//                dataType: "json",
                success: function (data) {
                    if (data != '' || data != undefined || data != null)
                    {
                        $('#group').html(data);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown)
                }
            });
        }
    </script>
@endsection
