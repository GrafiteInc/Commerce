@extends('quarx-frontend::layout.master')

@section('stylesheets')
    <link rel="stylesheet" href="{!! asset('css/store.css') !!}">
@stop

@section('store-header')
    @include('quazar-frontend::layouts.store_header')
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
    <script src="{!! asset('js/store.js') !!}"></script>
@stop