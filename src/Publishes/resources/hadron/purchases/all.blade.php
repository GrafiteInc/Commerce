@extends('hadron-frontend::layouts.store')

@section('store-content')

    <table class="table table-stripped">
        <thead>
            <td>ID</td>
            <td>Total</td>
            <td class="text-right">Actions</td>
        </thead>
        <tbody>
            @foreach ($purchases as $purchase)
                <tr>
                    <td><a href="{{ url('store/account/purchases/'.Crypto::encrypt($purchase->id)) }}">{!! $purchase->uuid !!}</a></td>
                    <td>${!! $purchase->total !!}</td>

                    <td class="text-right">
                        @if (!$purchase->refund_requested && is_null($purchase->refund_date))
                            <a href="{{ url('store/account/purchases/'.Crypto::encrypt($purchase->id).'/refund-request') }}">Request a Refund</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {!! $purchases !!}

@endsection

