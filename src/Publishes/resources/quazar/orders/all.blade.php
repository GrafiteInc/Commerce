@extends('quazar-frontend::layouts.store')

@section('store-content')

    <h1>Orders</h1>

    <table class="table table-stripped">
        <thead>
            <td>Date</td>
            <td>Transaction</td>
            <td>Status</td>
            <td class="text-right">Action</td>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td><a href="{{ route('quazar.account.order', [$order->uuid]) }}">{!! $order->created_at->format('Y-m-d') !!}</a></td>
                    <td>{!! $order->transaction('uuid') !!}</td>
                    <td>{!! ucfirst($order->status) !!}</td>
                    <td class="text-right">
                        @if ($order->status !== 'cancelled')
                            <a href="{{ route('quazar.account.order.cancel', [$order->uuid]) }}">Cancel Order</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {!! $orders !!}

@endsection

