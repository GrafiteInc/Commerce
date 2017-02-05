@extends('quazar-frontend::layouts.store')

@section('store-content')

    <h1>Subscription</h1>

    <table class="table table-stripped">
        <tr>
            <td>Name</td>
            <td class="text-right">{{ $subscription->name }}</td>
        </tr>
        <tr>
            <td>Ending On</td>
            <td class="text-right">{{ $subscription->ends_at }}</td>
        </tr>
        <tr>
            <td>Created On</td>
            <td class="text-right">{{ $subscription->created_at }}</td>
        </tr>
        <tr>
            <td>Details</td>
            <td class="text-right">{{ StoreHelper::subscriptionPlan($subscription)->description }}</td>
        </tr>
        @if (is_null($subscription->ends_at))
            <tr>
                <td>Upcoming</td>
                <td class="text-right">
                    {{ StoreHelper::subscriptionUpcoming($subscription)['total'] }}<br>
                    {{ StoreHelper::subscriptionUpcoming($subscription)['date'] }}
                </td>
            </tr>
        @endif
    </table>

    @if (is_null($subscription->ends_at))
        {!! StoreHelper::cancelSubscriptionBtn($subscription, 'btn btn-danger pull-right') !!}
    @endif

@endsection

