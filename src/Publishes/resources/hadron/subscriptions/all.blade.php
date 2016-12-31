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
                @if (StoreHelper::subscriptionPlan($subscription))
                    <tr>
                        <td><a href="{{ StoreHelper::customerSubscriptionUrl($subscription) }}">{!! $subscription->name !!}</a></td>
                        <td>${{ StoreHelper::subscriptionPlan($subscription)->price }}</td>
                        <td>@if (is_null($subscription->ends_at)) {!! StoreHelper::cancelSubscriptionBtn($subscription->name, 'btn btn-xs btn-danger') !!} @endif</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    {!! $subscriptions !!}

@endsection

