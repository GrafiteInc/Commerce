@extends('quazar-frontend::layouts.store')

@section('store-content')

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
                    <td><a href="{{ url('store/account/orders/'.crypto_encrypt($order->id)) }}">{!! $order->created_at->format('Y-m-d') !!}</a></td>
                    <td>{!! $order->transaction('uuid') !!}</td>
                    <td>{!! ucfirst($order->status) !!}</td>
                    <td class="text-right"><a href="{{ url('store/account/orders/'.crypto_encrypt($order->id).'/cancel') }}">Cancel Order</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {!! $orders !!}

@endsection

