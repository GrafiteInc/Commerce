@extends('commerce-frontend::layouts.store')

@section('store-content')

    <h3 class="mb-4">Purchase</h3>

    @if ($purchase->refund_requested && is_null($purchase->refund_date))
        <div class="alert alert-warning">
            You have requested a refund for this purchase
        </div>
    @elseif (($purchase->refund_requested && !is_null($purchase->refund_date)) || !is_null($purchase->refund_date))
        <div class="alert alert-info">
            You were refunded for this purchase
        </div>
    @endif

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

        @if ($purchase->coupon)
        <tr>
            <td>Coupon</td>
            <td class="text-right">${!! app(\SierraTecnologia\Commerce\Models\Coupon::class)->fill(json_decode($purchase->coupon, true))->dollars !!}</td>
        </tr>
        @endif

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
                    <td><a href="{{ $product->href }}">{!! $product->name !!}</a></td>
                    <td>{!! $product->code !!}</td>
                    @if (! empty($product->file))
                        <a class="btn btn-secondary btn-sm raw-margin-top-24" href="{!! $product->file_download_href !!}">
                        <span class="fa fa-download"></span> Download</a>
                    @else
                    <td class="text-right">{!! $product->details !!}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection

