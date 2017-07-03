@extends('quarx::layouts.dashboard', ['pageTitle' => 'Plans'])

@section('content')

    <div class="row">
        <a class="btn btn-primary pull-right" href="{!! route(config('quarx.backend-route-prefix', 'quarx').'.coupons.create') !!}">Add New</a>
        <div class="pull-right">
            {!! Form::open(['url' => config('quarx.backend-route-prefix', 'quarx').'/coupons/search']) !!}
             <input class="form-control header-input pull-right raw-margin-right-24" name="term" placeholder="Search">
            {!! Form::close() !!}
        </div>
        <h1 class="page-header">Coupons</h1>
    </div>

    <div class="row">
        @if (isset($term))
        <div class="well text-center">Searched for "{!! $term !!}".</div>
        @endif
        @if ($coupons->isEmpty())
            <div class="well text-center">No coupons found.</div>
        @else
            <table class="table table-striped">
                <thead>
                    <th>Name</th>
                    <th>Expired</th>
                    <th>For Subscription</th>
                    <th>Value</th>
                    <th class="text-right" width="150px">Actions</th>
                </thead>

                <tbody>
                @foreach($coupons as $coupon)
                    <tr>
                        <td><a href="{!! route(config('quarx.backend-route-prefix', 'quarx').'.coupons.show', [$coupon->id]) !!}">{{ $coupon->code }}</a></td>
                        <td>@if ($coupon->expired()) <span class="fa fa-check"></span> @endif</td>
                        <td>@if ($coupon->for_subscriptions) <span class="fa fa-check"></span> @endif</td>
                        <td>{{ $coupon->value_string }}</td>
                        <td class="text-right">
                            <a class="btn btn-default btn-xs pull-right" href="{!! route(config('quarx.backend-route-prefix', 'quarx').'.coupons.show', [$coupon->id]) !!}"><i class="fa fa-eye"></i> View</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="row">
                {!! $coupons !!}
            </div>
        @endif
    </div>

@stop
