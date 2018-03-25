@extends('commerce-frontend::layouts.store')

@section('store-content')

    @include('commerce-frontend::profile.tabs')

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2>Coupon</h2>

            <form id="" method="post" action="{!! route('commerce.account.profile.coupon') !!}">
                {!! csrf_field() !!}
                <div class="form-group">
                    <input class="form-control" name="coupon" placeholder="Coupon Code">
                </div>
                <br />
                <input class="btn btn-primary pull-right" type="submit" value="Apply">
            </form>
        </div>
    </div>

@endsection
