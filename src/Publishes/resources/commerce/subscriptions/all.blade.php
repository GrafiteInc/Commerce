@extends('commerce-frontend::layouts.store')

@section('store-content')

    <h3 class="mb-4">Subscriptions</h3>

    <table class="table table-stripped">
        <thead>
            <td>ID</td>
            <td>Total</td>
            <td class="text-right">Action</td>
        </thead>
        <tbody>
            @foreach ($subscriptions as $subscription)
                @if (StoreHelper::subscriptionPlan($subscription))
                    <tr>
                        <td><a href="{{ StoreHelper::customerSubscriptionUrl($subscription) }}">{!! $subscription->name !!}</a></td>
                        <td>${{ StoreHelper::subscriptionPlan($subscription)->amount }}</td>
                        <td class="text-right">@if (is_null($subscription->ends_at)) {!! StoreHelper::cancelSubscriptionBtn($subscription, 'btn btn-sm btn-danger') !!} @endif</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    {!! $subscriptions !!}

@endsection

