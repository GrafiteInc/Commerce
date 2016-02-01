@extends('hadron-frontend::layouts.store')

@section('store-content')

    <table class="table table-stripped">
        <thead>
            <td>ID</td>
            <td>Total</td>
            <td>Action</td>
        </thead>
        <tbody>
            @foreach ($subscriptions as $subscription)
                <tr>
                    <td><a href="{{ url('store/account/subscriptions/'.$subscription->id) }}">{!! $subscription->uuid !!}</a></td>
                    <td>${!! $subscription->total !!}</td>
                    <td><a href="{{ url('store/account/subscriptions/'.$subscription->id.'/refund-request') }}">Refund Request</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {!! $subscriptions !!}

@endsection

