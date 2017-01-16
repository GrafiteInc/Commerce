@extends('quarx-frontend::layout.master')

@section('stylesheets')
    {!! Minify::stylesheet(asset('css/store.css')) !!}
@stop

@section('store-header')
    @include('hadron-frontend::layouts.store_header')
@stop

@section('content')

    <div class="main">
        <div class="container">
            @yield("store-header")
        </div>
        <div class="container">
            @yield('store-content')
        </div>
    </div>

@stop

@section('pre-javascript')
    @parent
@stop

@section('javascript')
    @parent
    {!! Minify::javascript(asset('js/store.js')) !!}
@stop