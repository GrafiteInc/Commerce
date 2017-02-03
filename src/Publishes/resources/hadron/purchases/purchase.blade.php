@extends('quazar-frontend::layouts.store')

@section('store-content')

    <table class="table table-stripped">
        <tr>
            <td>ID</td>
            <td class="text-right">{!! $purchase->uuid !!}</td>
        </tr>
        <tr>
            <td>Date</td>
            <td class="text-right">{!! $purchase->created_at->format('Y-m-d') !!}</td>
        </tr>
        <tr>
            <td>Subtotal</td>
            <td class="text-right">{!! $purchase->subtotal !!}</td>
        </tr>
        <tr>
            <td>Tax</td>
            <td class="text-right">{!! $purchase->tax !!}</td>
        </tr>
        <tr>
            <td>Shipping</td>
            <td class="text-right">{!! $purchase->shipping !!}</td>
        </tr>
        <tr>
            <td>Total</td>
            <td class="text-right">{!! $purchase->total !!}</td>
        </tr>

    </table>

    <table class="table table-stripped">
        <thead>
            <td>Name</td>
            <td>Code</td>
            <td class="text-right">Details</td>
        </thead>
        <tbody>
            @foreach (json_decode($purchase->cart) as $product)
                <tr>
                    <td><a href="{{ StoreHelper::productUrl($product->url) }}">{!! $product->name !!}</a></td>
                    <td>{!! $product->code !!}</td>
                    <td class="text-right">
                        @if (! empty($product->file))
                            <a class="btn btn-default raw-margin-top-24" href="{!! url(FileService::fileAsDownload($product->file, $product->file)) !!}">
                            <span class="fa fa-download"></span> Download</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection

