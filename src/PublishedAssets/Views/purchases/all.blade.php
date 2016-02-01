@extends('hadron-frontend::layouts.store')

@section('store-content')

    <table class="table table-stripped">
        <thead>
            <td>ID</td>
            <td>Total</td>
            <td>Action</td>
        </thead>
        <tbody>
            @foreach ($purchases as $purchase)
                <tr>
                    <td><a href="{{ url('store/account/purchases/'.$purchase->id) }}">{!! $purchase->uuid !!}</a></td>
                    <td>${!! $purchase->total !!}</td>
                    <td><a href="{{ url('store/account/purchases/'.$purchase->id.'/refund-request') }}">Refund Request</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {!! $purchases !!}

@endsection

