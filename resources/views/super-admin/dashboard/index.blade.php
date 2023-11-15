@if(Auth::user()->is_new == 'no')
    @extends('layouts.super-admin.layouts')
@section('content')
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                @if(Auth::user()->role=='admin' || Auth::user()->role=='demo')
                                    @includeIf('super-admin.dashboard.admin-index')
                                @endif

                                
                                @if(Auth::user()->role=='others' )
                                    @includeIf('super-admin.dashboard.customer-index')
                                @endif

                                @if(Auth::user()->role == 'agent')
                                    @includeIf('super-admin.dashboard.agent-index')
                                @endif
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{--@section('page-specific-scripts')--}}
    {{--{!! $chart1->renderChartJsLibrary() !!}--}}
    {{--{!! $chart1->renderJs() !!}--}}
{{--@endsection--}}
@else
    @includeIf('super-admin.login.after-login')
@endif

