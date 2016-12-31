@extends('hadron-frontend::layouts.store')

@section('store-content')

    <h1>Subscription</h1>
    <p>{{ $subscription->name }}</p>
    <p>Ending On: {{ $subscription->ends_at }}</p>
    <p>Created On: {{ $subscription->created_at }}</p>
    @if (is_null($subscription->ends_at))
        {!! StoreHelper::cancelSubscriptionBtn($subscription->name) !!}
    @endif

    @if (is_null($subscription->ends_at))
    <h2>Upcoming</h2>
    <p>Total: {{ StoreHelper::subscriptionUpcoming($subscription)['total'] }}</p>
    <p>Date: {{ StoreHelper::subscriptionUpcoming($subscription)['date'] }}</p>
    @endif

@endsection

