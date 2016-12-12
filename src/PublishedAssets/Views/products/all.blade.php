@extends('hadron-frontend::layouts.store')

@section('content')

    @include('quarx::frontend.store.products.featured')

    <table class="table table-stripped">
        <thead>
            <td>Name</td>
            <td>Code</td>
            <td>Price</td>
            <td>Action</td>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td><a href="{{ StoreHelper::productUrl($product->url) }}">{!! $product->name !!}</a></td>
                    <td>{!! $product->code !!}</td>
                    <td>${!! $product->price !!}</td>
                    <td>{!! StoreHelper::addToCartBtn($product->id, 'product', 'Add To Cart <span class="fa fa-shopping-cart"></span>') !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {!! QuarxService::widget('test') !!}

@endsection
