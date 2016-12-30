@extends('hadron-frontend::layouts.store')

@section('store-content')

    @include('hadron-frontend::profile.tabs')

    <table class="table table-striped">
        @if (! is_null(Customer::lastCard('card_last_four')))
            <tr>
                <td>Last Card Number</td>
                <td>**** **** **** {!! Customer::lastCard('card_last_four') !!}</td>
            </tr>
            <tr>
                <td>Last Card Brand</td>
                <td>{!! Customer::lastCard('card_brand') !!}</td>
            </tr>
        @endif
        <tr>
            <td>Shipping Address</td>
            <td>
                {!! Customer::shippingAddress('street') !!}
                {!! Customer::shippingAddress('postal') !!}
                {!! Customer::shippingAddress('city') !!}
                {!! Customer::shippingAddress('state') !!}
                {!! Customer::shippingAddress('country') !!}
            </td>
        </tr>
        <tr>
            <td>Billing Address</td>
            <td>
                {!! Customer::billingAddress('street') !!}
                {!! Customer::billingAddress('postal') !!}
                {!! Customer::billingAddress('city') !!}
                {!! Customer::billingAddress('state') !!}
                {!! Customer::billingAddress('country') !!}
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

