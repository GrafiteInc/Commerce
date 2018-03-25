@extends('cms::layouts.dashboard', ['pageTitle' => 'Coupons'])

@section('content')

    @include('commerce::modals')

    <div class="row">
        <h1>Coupon: Details</h1>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            {!! FormMaker::fromObject($coupon, config('commerce.forms.coupons')) !!}

            <form id="deleteCouponForm" method="post" action="{!! url(config('cms.backend-route-prefix', 'cms').'/coupons/'.$coupon->id) !!}">
                {!! csrf_field() !!}
                {!! method_field('DELETE') !!}
                <button class="btn delete-coupon-btn btn-danger pull-right" type="submit"><i class="fa fa-trash"></i> Delete</button>
            </form>
        </div>
    </div>

@stop

@section('javascript')
    @parent
    <script type="text/javascript" src="{{ Cms::moduleAsset('commerce', 'js/coupons.js', 'application/javascript') }}"></script>
@endsection
