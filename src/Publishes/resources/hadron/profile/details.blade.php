@extends('hadron-frontend::layouts.store')

@section('store-content')

    @include('hadron-frontend::profile.tabs')

    <table class="table table-striped">
        @if (! is_null(StoreHelper::customer()->lastCard('card_last_four')))
            <tr>
                <td>Last Card Number</td>
                <td>**** **** **** {!! StoreHelper::customer()->lastCard('card_last_four') !!}</td>
            </tr>
            <tr>
                <td>Last Card Brand</td>
                <td>{!! StoreHelper::customer()->lastCard('card_brand') !!}</td>
            </tr>
        @endif
        <tr>
            <td>Shipping Address</td>
            <td>
                {!! StoreHelper::customer()->shippingAddress('street') !!}
                {!! StoreHelper::customer()->shippingAddress('postal') !!}
                {!! StoreHelper::customer()->shippingAddress('city') !!}
                {!! StoreHelper::customer()->shippingAddress('state') !!}
                {!! StoreHelper::customer()->shippingAddress('country') !!}
            </td>
        </tr>
        <tr>
            <td>Billing Address</td>
            <td>
                {!! StoreHelper::customer()->billingAddress('street') !!}
                {!! StoreHelper::customer()->billingAddress('postal') !!}
                {!! StoreHelper::customer()->billingAddress('city') !!}
                {!! StoreHelper::customer()->billingAddress('state') !!}
                {!! StoreHelper::customer()->billingAddress('country') !!}
            </td>
        </tr>
    </table>

    <h2>Update Address</h2>

    <form id="" method="post" action="{!! url('store/account/profile/update') !!}">
        {!! Form::token() !!}
        <input class="form-control" name="street" placeholder="Street">
        <input class="form-control" name="postal" placeholder="Postal">
        <input class="form-control" name="city" placeholder="City">
        <input class="form-control" name="state" placeholder="State">
        <input class="form-control" name="country" placeholder="Country">
        <div class="form-group">
            <label>
                <input type="checkbox" name="shipping">
                Shipping
            </label>
        </div>
        <div class="form-group">
            <label>
                <input type="checkbox" name="billing">
                Billing
            </label>
        </div>
        <br />
        <input class="btn btn-primary" type="submit" value="Save">
    </form>

@endsection

