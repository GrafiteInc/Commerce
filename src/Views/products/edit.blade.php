@extends('quarx::layouts.dashboard')

@section('content')

    <div class="row">
        <h1 class="page-header">Products</h1>
    </div>

    @include('hadron::products.breadcrumbs', ['location' => ['edit']])

    @if ($product->hero_image)
        <div class="row">
            <div class="col-lg-4 col-lg-offset-4">
                <img class="thumbnail raw100" alt="" src="{{ FileService::fileAsPublicAsset($product->hero_image) }}" />
            </div>
        </div>
    @endif

    @include('hadron::products.tabs', $tabs)

@endsection

@section('javascript')

    @parent
    {!! Minify::javascript(Hadron::asset('js/products.js', 'application/javascript')) !!}

@endsection
