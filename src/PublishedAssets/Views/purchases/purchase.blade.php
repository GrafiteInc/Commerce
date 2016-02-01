@extends('hadron-frontend::layouts.store')

@section('store-content')

    <table>
        <tr>
            <td>ID</td>
            <td>{!! $purchase->uuid !!}</td>
        </tr>
        <tr>
            <td>Date</td>
            <td>{!! $purchase->created_at->format('Y-m-d') !!}</td>
        </tr>
        <tr>
            <td>Subtotal</td>
            <td>{!! $purchase->subtotal !!}</td>
        </tr>
        <tr>
            <td>Tax</td>
            <td>{!! $purchase->tax !!}</td>
        </tr>
        <tr>
            <td>Shipping</td>
            <td>{!! $purchase->shipping !!}</td>
        </tr>
        <tr>
            <td>Total</td>
            <td>{!! $purchase->total !!}</td>
        </tr>

    </table>

    <table class="table table-stripped">
        <thead>
            <td>Name</td>
            <td>Code</td>
        </thead>
        <tbody>
            @foreach (json_decode($purchase->cart) as $product)
                <tr>
                    <td><a href="{{ StoreHelper::productUrl($product->url) }}">{!! $product->name !!}</a></td>
                    <td>{!! $product->code !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection

