@extends('hadron-frontend::layouts.store')

@section('store-content')

    <h1>Shopping Cart</h1>

    <form method="post" action="{!! url('store/calculate/shipping') !!}">
        {!! Form::token() !!}
        <div class="row">
            <h2>Shipping Info</h2>
            <input class="form-control" required name="address[street]" placeholder="Street" value="{!! Customer::shippingAddress('street') !!}">
            <input class="form-control" required name="address[postal]" placeholder="Postal" value="{!! Customer::shippingAddress('postal') !!}">
            <input class="form-control" required name="address[city]" placeholder="City" value="{!! Customer::shippingAddress('city') !!}">
            <input class="form-control" required name="address[state]" placeholder="State" value="{!! Customer::shippingAddress('state') !!}">
            <input class="form-control" required name="address[country]" placeholder="Country" value="{!! Customer::shippingAddress('country') !!}">
        </div>
        <input type="submit" value="Re-calculate Shipping">
    </form>

    @include('hadron-frontend::checkout.products')

    <a class="pull-right" href="{!! URL::to('store/payment') !!}">Purchase</a>

@endsection
