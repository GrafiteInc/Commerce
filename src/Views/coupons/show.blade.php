@extends('quarx::layouts.dashboard', ['pageTitle' => 'Coupons'])

@section('content')

    @include('quazar::modals')

    <div class="row">
        <h1>Coupon: Details</h1>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            {!! FormMaker::fromObject($coupon, config('quazar.forms.coupons')) !!}

            <form id="deleteCouponForm" method="post" action="{!! url(config('quarx.backend-route-prefix', 'quarx').'/coupons/'.$coupon->id) !!}">
                {!! csrf_field() !!}
                {!! method_field('DELETE') !!}
                <button class="btn delete-coupon-btn btn-danger pull-right" type="submit"><i class="fa fa-trash"></i> Delete</button>
            </form>
        </div>
    </div>

@stop

@section('javascript')
    @parent
    <script type="text/javascript" src="{{ Quarx::moduleAsset('quazar', 'js/coupons.js', 'application/javascript') }}"></script>
@endsection
