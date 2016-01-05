@extends('hadron-frontend::layouts.store')

@section('store-content')

    <table class="table table-stripped">
        <thead>
            <td>Name</td>
            <td>Code</td>
            <td>Price</td>
            <td>Quantity</td>
            <td>Action</td>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr data-cart-row="{!! $product->cart_id !!}">
                    <td>
                        <a href="{{ StoreHelper::productUrl($product->url) }}">{!! $product->name !!}</a>
                    </td>
                    <td>{!! $product->code !!}</td>
                    <td>{!! $product->price() !!}</td>
                    <td><input class="store-form product-count" data-product="{!! $product->cart_id !!}" value="{!! $product->quantity !!}"></td>
                    <td>{!! StoreHelper::removeFromCartBtn($product->cart_id, $product->entity_type, 'Remove From Cart <span class="fa fa-shopping-cart"></span>') !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a class="pull-right" href="{!! URL::to('store/checkout') !!}">Checkout</a>

@endsection

