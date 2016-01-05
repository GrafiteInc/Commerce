@extends('quarx::quarx.layouts.dashboard')

@section('content')

        <div class="row">
            <h1 class="page-header">Products</h1>
        </div>

        @include('quarx::quarx.products.breadcrumbs', ['location' => ['edit']])

        @if ($products->hero_image)
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4">
                    <img class="thumbnail raw100" alt="" src="{{ FileService::fileAsPublicAsset($products->hero_image) }}" />
                </div>
            </div>
        @endif

        @include('quarx::quarx.products.tabs', $tabs)

    </div>
@endsection

@section('javascript')

    @parent
    {!! Minify::javascript(Quarx::asset('js/products.js', 'application/javascript')) !!}

@endsection
