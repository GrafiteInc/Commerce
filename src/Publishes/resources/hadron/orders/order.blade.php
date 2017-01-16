@extends('hadron-frontend::layouts.store')

@section('store-content')

    <table class="table table-stripped">
        <tr>
            <td>Date</td>
            <td class="text-right">{!! $order->created_at->format('Y-m-d') !!}</td>
        </tr>
        <tr>
            <td>Transaction</td>
            <td class="text-right"><a href="{!! url('store/account/purchases/'.Crypto::encrypt($order->transaction()->id)) !!}">{!! $order->transaction('uuid') !!}</a></td>
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
            @foreach (json_decode($order->details) as $product)
                <tr>
                    <td><a href="{{ StoreHelper::productUrl($product->url) }}">{!! $product->name !!}</a></td>
                    <td>{!! $product->code !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection

