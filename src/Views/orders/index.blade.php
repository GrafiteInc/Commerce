@extends('quarx::layouts.dashboard')

@section('content')

    <div class="row">
        <div class="raw-m-hide pull-right">
            {!! Form::open(['url' => 'quarx/orders/search']) !!}
            <input class="form-control header-input pull-right raw-margin-right-24" name="term" placeholder="Search">
            {!! Form::close() !!}
        </div>
        <h1 class="page-header">Orders</h1>
    </div>

    <div class="row">
        @if (isset($term))
        <div class="well text-center">Searched for "{!! $term !!}".</div>
        @endif
        @if($orders->count() === 0)
            <div class="well text-center">No Orders found.</div>
        @else
            <table class="table table-striped">
                <thead>
                    <th>Uuid</th>
                    <th class="raw-m-hide">Transaction #</th>
                    <th class="raw-m-hide">Customer</th>
                    <th class="raw-m-hide">Status</th>
                    <th class="raw-m-hide">Shipped</th>
                    <th class="raw-m-hide">Tracking #</th>
                    <th width="100px" class="text-right">Action</th>
                </thead>
                <tbody>

                @foreach($orders as $order)
                    <tr>
                        <td><a href="{!! route('quarx.orders.edit', [$order->id]) !!}">{!! $order->uuid !!}</a></td>
                        <td class="raw-m-hide"><a href="{!! route('quarx.transactions.edit', [$order->transaction('id')]) !!}">{!! $order->transaction('uuid') !!}</a></td>
                        <td class="raw-m-hide">{!! auth()->user()->find($order->user_id)->name !!}</td>
                        <td class="raw-m-hide">{!! ucfirst($order->status) !!}</td>
                        <td class="raw-m-hide text-center">
                            @if ($order->is_shipped)
                                <span class="fa fa-truck"></span>
                            @else
                                <span class="fa fa-close"></span>
                            @endif
                        </td>
                        <td class="raw-m-hide">{!! $order->tracking_number !!}</td>
                        <td class="text-right">
                            <a class="btn btn-xs btn-default pull-right" href="{!! route('quarx.orders.edit', [$order->id]) !!}"><i class="fa fa-pencil"></i> Edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="text-center">
        {{ $pagination }}
    </div>

@endsection
