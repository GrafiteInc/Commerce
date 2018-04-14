@extends('commerce-frontend::layouts.store')

@section('store-content')

    <h1 class="mb-4">Checkout: Confirmation</h1>

    <div class="row">
        <div class="col-md-4">
            <h4 class="mb-4">Shipping Info</h4>
            <form method="post" action="{!! route('commerce.calculate.shipping') !!}">
                {!! csrf_field() !!}
                <div class="form-group">
                    <input class="form-control" required name="address[street]" placeholder="Street" value="{!! commerce()->customer()->shippingAddress('street') !!}">
                </div>
                <div class="form-group">
                    <input class="form-control" required name="address[postal]" placeholder="Postal" value="{!! commerce()->customer()->shippingAddress('postal') !!}">
                </div>
                <div class="form-group">
                    <input class="form-control" required name="address[city]" placeholder="City" value="{!! commerce()->customer()->shippingAddress('city') !!}">
                </div>
                <div class="form-group">
                    <input class="form-control" required name="address[state]" placeholder="State" value="{!! commerce()->customer()->shippingAddress('state') !!}">
                </div>
                <div class="form-group">
                    <input class="form-control" required name="address[country]" placeholder="Country" value="{!! commerce()->customer()->shippingAddress('country') !!}">
                </div>
                <input class="btn btn-outline-secondary pull-right" type="submit" value="Re-calculate Shipping">
            </form>
        </div>
        <div class="col-md-8">
            <h4 class="mb-4">Shopping Cart</h4>
            @include('commerce-frontend::checkout.coupon')
            @include('commerce-frontend::checkout.products')
            <a class="pull-right btn btn-primary" href="{!! route('commerce.payment') !!}">Purchase</a>
        </div>
    </div>

@endsection
