@extends('commerce-frontend::layouts.store')

@section('store-content')

    <h3 class="mb-4">Order</h3>

    <table class="table table-stripped">
        <tr>
            <td>Date</td>
            <td class="text-right">{!! $order->created_at->format('Y-m-d') !!}</td>
        </tr>
        <tr>
            <td>Transaction</td>
            <td class="text-right"><a href="{!! route('commerce.account.purchase', [$order->transaction->uuid]) !!}">{!! $order->transaction->uuid !!}</a></td>
        </tr>
        <tr>
            <td>Status</td>
            <td class="text-right"> {!! ucfirst($order->status) !!}</td>
        </tr>

        <tr>
            <td>Address</td>
            <td class="text-right">
                {!! $order->shippingAddress('street') !!}<br>
                {!! $order->shippingAddress('postal') !!}<br>
                {!! $order->shippingAddress('city') !!}<br>
                {!! $order->shippingAddress('state') !!}<br>
                {!! $order->shippingAddress('country') !!}<br>
            </td>
        </tr>

    </table>

    <table class="table table-stripped">
        <thead>
            <td>Name</td>
            <td>Code</td>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td><a href="{{ $item->product->href }}">{!! $item->product->name !!}</a></td>
                    <td>{!! $item->product->code !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection

