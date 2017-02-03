@extends('quazar-frontend::layouts.store')

@section('store-content')

    @if (count($products) > 0)
        <table class="table table-stripped">
            <thead>
                <td>Name</td>
                <td>Code</td>
                <td>Price</td>
                <td>Quantity</td>
                <td class="text-right">Action</td>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr data-cart-row="{!! $product->cart_id !!}">
                        <td>
                            <a href="{{ $product->href }}">{!! $product->name !!}</a>
                        </td>
                        <td>{!! $product->code !!}</td>
                        <td>${!! $product->price !!}</td>
                        <td>
                            <div class="form-group">
                                <div class="input-group store-input-group pull-left">
                                    <div class="input-group-addon cart-subtract"><span class="fa fa-minus"></span></div>
                                    <input class="store-form product-count text-center" data-product="{!! $product->cart_id !!}" value="{!! $product->quantity !!}">
                                    <div class="input-group-addon cart-add"><span class="fa fa-plus"></span></div>
                                </div>
                            </div>
                        </td>
                        <td class="text-right">{!! $product->removeFromCartBtn($product->cart_id, 'Remove From Cart <span class="fa fa-shopping-cart"></span>', 'btn btn-link btn-warning') !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{!! url('store/cart/empty') !!}">
            <span class="pull-left">
                <span class="fa fa-shopping-cart"></span>
                Empty Cart
            </span>
        </a>
        <a class="pull-right" href="{!! url('store/checkout') !!}">Checkout</a>
    @else
        <div class="well text-center">
            Hmm, nothing to see here.
        </div>
    @endif

@endsection
