@extends('quarx::quarx.layouts.navigation')

@section('page-content')

    <div class="overlay"></div>

    {!! Minify::stylesheet(Quarx::asset('css/dashboard.css', 'text/css')) !!}

    <div class="raw100 raw-left raw-margin-top-50">
        <div class="col-sm-3 col-md-2 sidebar">
            <div class="raw100 raw-left raw-margin-bottom-90">
                @include('quarx::quarx.dashboard.panel')
            </div>
        </div>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            @yield('content')
        </div>
    </div>

    <div class="raw100 raw-left navbar navbar-fixed-bottom">
        <div class="raw100 raw-left gondolyn-footer">
            <p class="raw-margin-left-20">&copy; {!! date('Y'); !!} <a href="http://mattlantz.ca">Matt Lantz</a></p>
        </div>
    </div>
@stop

@section('javascript')
    {!! Minify::javascript(Quarx::asset('js/dashboard.js', 'application/javascript')) !!}
    {!! Minify::javascript(Quarx::asset('js/chart.min.js', 'application/javascript')) !!}
@stop
