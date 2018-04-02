@extends('commerce-frontend::layouts.store')

@section('store-content')

    <h3 class="mb-4">Purchases</h3>

    <table class="table table-stripped">
        <thead>
            <td>ID</td>
            <td>Total</td>
            <td class="text-right">Actions</td>
        </thead>
        <tbody>
            @foreach ($purchases as $purchase)
                <tr>
                    <td><a href="{{ route('commerce.account.purchase', [$purchase->uuid]) }}">{!! $purchase->uuid !!}</a></td>
                    <td>${!! $purchase->total !!}</td>

                    <td class="text-right">
                        @if (!$purchase->refund_requested && is_null($purchase->refund_date))
                            <a href="{{ route('commerce.account.purchase.refund-request', [$purchase->uuid]) }}">Request a Refund</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {!! $purchases !!}

@endsection

