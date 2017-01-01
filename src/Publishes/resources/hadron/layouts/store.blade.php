@extends('quarx-frontend::layout.master')

@section('stylesheets')
    {!! Minify::stylesheet(asset('css/store.css')) !!}
@stop

@section('store-header')
    <div class="store-header">
        <h2><a href="{!! url('store') !!}">Our Store</a>
            <a href="{!! url('store/cart/contents') !!}">
                <span class="pull-right">
                    <span class="fa fa-shopping-cart"></span>
                    <span class="cart-count"></span>
                </span>
            </a>
            <a href="{!! url('store/cart/empty') !!}">
                <span class="pull-right icon-stack">
                    <span class="fa fa-shopping-cart icon-stack-1x"></span>
                    <span class="fa fa-remove text-danger icon-stack-2x"></span>
                </span>
            </a>
        </h2>
    </div>
@stop

@section('content')

    @include('hadron-frontend::layouts.navigation')

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