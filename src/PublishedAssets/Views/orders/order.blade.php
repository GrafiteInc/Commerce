@extends('hadron-frontend::layouts.store')

@section('store-content')

    <table>
        <tr>
            <td>Date</td>
            <td>{!! $order->created_at->format('Y-m-d') !!}</td>
        </tr>
        <tr>
            <td>Transaction</td>
            <td><a href="{!! url('store/account/purchases/'.$order->transaction()->id) !!}">{!! $order->transaction()->uuid !!}</a></td>
        </tr>

        <tr>
            <td>Address</td>
            <td>
                {!! json_decode($order->shipping_address)->street !!}
                {!! json_decode($order->shipping_address)->postal !!}
                {!! json_decode($order->shipping_address)->city !!}
                {!! json_decode($order->shipping_address)->state !!}
                {!! json_decode($order->shipping_address)->country !!}
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

