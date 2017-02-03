@extends('quazar-frontend::layouts.store')

@section('store-content')

    <h1>Shopping Cart</h1>

    <form method="post" action="{!! url('store/calculate/shipping') !!}">
        {!! Form::token() !!}
        <div class="row">
            <h2>Shipping Info</h2>
            <input class="form-control" required name="address[street]" placeholder="Street" value="{!! StoreHelper::customer()->shippingAddress('street') !!}">
            <input class="form-control" required name="address[postal]" placeholder="Postal" value="{!! StoreHelper::customer()->shippingAddress('postal') !!}">
            <input class="form-control" required name="address[city]" placeholder="City" value="{!! StoreHelper::customer()->shippingAddress('city') !!}">
            <input class="form-control" required name="address[state]" placeholder="State" value="{!! StoreHelper::customer()->shippingAddress('state') !!}">
            <input class="form-control" required name="address[country]" placeholder="Country" value="{!! StoreHelper::customer()->shippingAddress('country') !!}">
        </div>
        <input type="submit" value="Re-calculate Shipping">
    </form>

    @include('quazar-frontend::checkout.products')

    <a class="pull-right" href="{!! url('store/payment') !!}">Purchase</a>

@endsection
