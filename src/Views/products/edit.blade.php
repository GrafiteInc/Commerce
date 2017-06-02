@extends('quarx::layouts.dashboard')

@section('stylesheets')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ Quarx::moduleAsset('quazar', 'css/store.css', 'text/css') }}">
@stop

@section('content')

    <div class="row">
        <a class="btn btn-primary pull-right" href="{!! route(config('quarx.backend-route-prefix', 'quarx').'.products.create') !!}">Add New</a>
        <h1 class="page-header">Products</h1>
    </div>

    @include('quazar::products.breadcrumbs', ['location' => ['edit']])

    @if ($product->hero_image)
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center">
                <img class="thumbnail" style="display: inline-block;" src="{{ $product->hero_image_url }}" />
            </div>
        </div>
    @endif

    @include('quazar::products.tabs', $tabs)

@endsection

@section('javascript')

    @parent
    {!! Minify::javascript(Quarx::moduleAsset('quazar', 'js/products.js', 'application/javascript')) !!}

@endsection
