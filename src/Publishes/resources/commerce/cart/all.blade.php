@extends('commerce-frontend::layouts.store')

@section('store-content')

    <h3 class="mb-4">Shopping Cart</h3>

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
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-sm btn-outline-secondary cart-subtract" type="button"><span class="fa fa-minus"></span></button>
                                    </div>
                                    <input class="store-form product-count text-center" data-product="{!! $product->cart_id !!}" value="{!! $product->quantity !!}">
                                    <div class="input-group-append">
                                        <button class="btn btn-sm btn-outline-secondary cart-add" type="button"><span class="fa fa-plus"></span></button>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-right">{!! $product->removeFromCartBtn($product->cart_id, 'Remove From Cart <span class="fa fa-shopping-cart"></span>', 'btn btn-sm btn-outline-warning') !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a class="btn btn-outline-warning" href="{!! route('commerce.cart.empty') !!}">
            <span class="fa fa-shopping-cart"></span>
            Empty Cart
        </a>
        <a class="float-right btn btn-primary" href="{!! route('commerce.checkout') !!}">Checkout</a>
    @else
        <div class="well text-center">
            Hmm, nothing to see here.
        </div>
    @endif

@endsection
