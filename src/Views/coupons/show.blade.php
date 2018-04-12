@extends('cms::layouts.dashboard')

@section('pageTitle') Coupons: Details @stop

@section('content')

    @include('commerce::modals')

    <div class="col-md-12 raw-margin-top-24">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                {!! FormMaker::fromObject($coupon, config('commerce.forms.coupons')) !!}

                <form id="deleteCouponForm" method="post" action="{!! url(config('cms.backend-route-prefix', 'cms').'/coupons/'.$coupon->id) !!}">
                    {!! csrf_field() !!}
                    {!! method_field('DELETE') !!}
                    <button class="btn delete-coupon-btn btn-danger pull-right" type="submit"><i class="fa fa-trash"></i> Delete</button>
                </form>
            </div>
        </div>
    </div>

@stop

@section('javascript')
    @parent
    <script type="text/javascript" src="{{ Cms::moduleAsset('commerce', 'js/coupons.js', 'application/javascript') }}"></script>
@endsection
