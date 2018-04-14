@extends('commerce-frontend::layouts.store')

@section('store-content')

    @include('commerce-frontend::profile.tabs')

    <div class="row">
        <div class="col-md-6">
            <h2>Update Address</h2>

            <form id="" method="post" action="{!! route('commerce.account.profile.update') !!}">
                {!! csrf_field() !!}
                <div class="form-group">
                    <input class="form-control" name="street" placeholder="Street">
                </div>
                <div class="form-group">
                    <input class="form-control" name="postal" placeholder="Postal">
                </div>
                <div class="form-group">
                    <input class="form-control" name="city" placeholder="City">
                </div>
                <div class="form-group">
                    <input class="form-control" name="state" placeholder="State">
                </div>
                <div class="form-group">
                    <input class="form-control" name="country" placeholder="Country">
                </div>
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
                <input class="btn btn-primary pull-right" type="submit" value="Save">
            </form>
        </div>
        <div class="col-md-6">
            <h2>Current Address</h2>
            <table class="table table-striped">
                <tr>
                    <td>Shipping Address</td>
                    <td>
                        {!! commerce()->customer()->shippingAddress('street') !!}
                        {!! commerce()->customer()->shippingAddress('postal') !!}
                        {!! commerce()->customer()->shippingAddress('city') !!}
                        {!! commerce()->customer()->shippingAddress('state') !!}
                        {!! commerce()->customer()->shippingAddress('country') !!}
                    </td>
                </tr>
                <tr>
                    <td>Billing Address</td>
                    <td>
                        {!! commerce()->customer()->billingAddress('street') !!}
                        {!! commerce()->customer()->billingAddress('postal') !!}
                        {!! commerce()->customer()->billingAddress('city') !!}
                        {!! commerce()->customer()->billingAddress('state') !!}
                        {!! commerce()->customer()->billingAddress('country') !!}
                    </td>
                </tr>
            </table>
        </div>
    </div>

@endsection

