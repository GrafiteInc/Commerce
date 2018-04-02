@extends('cms::layouts.dashboard')

@section('stylesheets')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ Cms::moduleAsset('commerce', 'css/store.css', 'text/css') }}">
@stop

@section('pageTitle') Products @stop

@section('content')

    <div class="col-md-12 mt-2">
        @include('commerce::products.breadcrumbs', ['location' => ['edit']])

        @include('commerce::products.tabs', $tabs)
    </div>

@endsection

@section('javascript')

    @parent
    {!! Minify::javascript(Cms::moduleAsset('commerce', 'js/products.js', 'application/javascript')) !!}

@endsection
