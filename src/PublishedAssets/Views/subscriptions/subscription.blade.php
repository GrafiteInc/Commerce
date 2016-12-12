@extends('hadron-frontend::layouts.store')

@section('store-content')

    <h1>Subscription</h1>
    <p>{{ $subscription->name }}</p>
    <p>Ending On: {{ $subscription->ends_at }}</p>
    <p>Created On: {{ $subscription->created_at }}</p>
    @if (is_null($subscription->ends_at))
        {!! StoreHelper::cancelSubscriptionBtn($subscription->name) !!}
    @endif

@endsection

