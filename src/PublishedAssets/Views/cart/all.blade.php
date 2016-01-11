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
                    <td>
                        <div class="form-group">
                            <div class="input-group store-input-group pull-left">
                                <div class="input-group-addon cart-subtract"><span class="fa fa-minus"></span></div>
                                <input class="store-form product-count text-center" data-product="{!! $product->cart_id !!}" value="{!! $product->quantity !!}">
                                <div class="input-group-addon cart-add"><span class="fa fa-plus"></span></div>
                            </div>
                        </div>
                    </td>
                    <td>{!! StoreHelper::removeFromCartBtn($product->cart_id, $product->entity_type, 'Remove From Cart <span class="fa fa-shopping-cart"></span>') !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a class="pull-right" href="{!! URL::to('store/checkout') !!}">Checkout</a>

@endsection

