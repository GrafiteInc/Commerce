@extends('quarx::layouts.dashboard', ['pageTitle' => 'Coupons'])

@section('content')

    @include('quazar::modals')

    <div class="row">
        <h1>Coupons: Edit</h1>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            {!! Form::model($coupon, ['route' => [config('quarx.backend-route-prefix', 'quarx').'.coupons.update', $coupon->id], 'method' => 'patch']) !!}

            {!! FormMaker::fromObject($coupon, config('quazar.forms.coupons-edit')) !!}

            {!! Form::submit('Update', ['class' => 'btn btn-primary pull-right']) !!}

            {!! Form::close() !!}

            <form id="deletePlanForm" method="post" action="{!! url(config('quarx.backend-route-prefix', 'quarx').'/coupons/'.$coupon->id) !!}">
                {!! csrf_field() !!}
                {!! method_field('DELETE') !!}
                <button class="btn delete-coupon-btn btn-danger pull-left" type="submit"><i class="fa fa-trash"></i> Delete</button>
            </form>
        </div>
    </div>

@stop
