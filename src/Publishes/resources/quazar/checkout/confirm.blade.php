@extends('quazar-frontend::layouts.store')

@section('store-content')

    <h1>Checkout: Confirmation</h1>

    <div class="row">
        <div class="col-md-4">
            <h2>Shipping Info</h2>
            <form method="post" action="{!! route('quazar.calculate.shipping') !!}">
                {!! csrf_field() !!}
                <div class="form-group">
                    <input class="form-control" required name="address[street]" placeholder="Street" value="{!! StoreHelper::customer()->shippingAddress('street') !!}">
                </div>
                <div class="form-group">
                    <input class="form-control" required name="address[postal]" placeholder="Postal" value="{!! StoreHelper::customer()->shippingAddress('postal') !!}">
                </div>
                <div class="form-group">
                    <input class="form-control" required name="address[city]" placeholder="City" value="{!! StoreHelper::customer()->shippingAddress('city') !!}">
                </div>
                <div class="form-group">
                    <input class="form-control" required name="address[state]" placeholder="State" value="{!! StoreHelper::customer()->shippingAddress('state') !!}">
                </div>
                <div class="form-group">
                    <input class="form-control" required name="address[country]" placeholder="Country" value="{!! StoreHelper::customer()->shippingAddress('country') !!}">
                </div>
                <input class="btn btn-info pull-right" type="submit" value="Re-calculate Shipping">
            </form>
        </div>
        <div class="col-md-8">
            <h2>Shopping Cart</h2>
            @include('quazar-frontend::checkout.products')
            <a class="pull-right" href="{!! route('quazar.payment') !!}">Purchase</a>
        </div>
    </div>

@endsection
