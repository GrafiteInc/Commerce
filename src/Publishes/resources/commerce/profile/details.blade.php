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
        </div>
    </div>

@endsection

