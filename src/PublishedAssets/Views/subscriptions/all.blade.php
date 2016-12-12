@extends('hadron-frontend::layouts.store')

@section('store-content')

    <h1>Subscriptions</h1>

    <table class="table table-stripped">
        <thead>
            <td>ID</td>
            <td>Total</td>
            <td>Action</td>
        </thead>
        <tbody>
            @foreach ($subscriptions as $subscription)
                <tr>
                    <td><a href="{{ url('store/account/subscriptions/'.Crypto::encrypt($subscription->id)) }}">{!! $subscription->name !!}</a></td>
                    <td>${!! app('Yab\Hadron\Models\Plan')->getPlansByStripeId($subscription->stripe_plan)->price !!}</td>
                    <td><a href="{{ url('store/account/subscriptions/'.Crypto::encrypt($subscription->id).'/cancel') }}">Cancel</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {!! $subscriptions !!}

@endsection

