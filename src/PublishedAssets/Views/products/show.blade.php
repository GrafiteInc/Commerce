@extends('hadron-frontend::layouts.store')

@section('store-content')

    <div class="row">
        <img class="thumbnail img-responsive" alt="" src="{{ StoreHelper::heroImage($product) }}" />
        <h1>{{ $product->name }}</h1>
        {!! StoreHelper::productVariants($product) !!}
        <label>Price</label>
        <p>{{ $product->price() }}</p>
        <span>{!! StoreHelper::addToCartBtn($product->id, 'product', 'Add To Cart <span class="fa fa-shopping-cart"></span>') !!}</span>
        {!! $product->details !!}
    </div>

@endsection
