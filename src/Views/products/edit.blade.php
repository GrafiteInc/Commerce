@extends('quarx::layouts.dashboard')

@section('content')

    <div class="row">
        <a class="btn btn-primary pull-right" href="{!! route('quarx.products.create') !!}">Add New</a>
        <h1 class="page-header">Products</h1>
    </div>

    @include('hadron::products.breadcrumbs', ['location' => ['edit']])

    @if ($product->hero_image)
        <div class="row">
            <div class="col-lg-4 col-lg-offset-4 raw-block-300">
                <img class="thumbnail raw100" alt="" src="{{ FileService::fileAsPublicAsset($product->hero_image) }}" />
            </div>
        </div>
    @endif

    @include('hadron::products.tabs', $tabs)

@endsection

@section('javascript')

    @parent
    {!! Minify::javascript(Quarx::moduleAsset('hadron', 'js/products.js', 'application/javascript')) !!}

@endsection
