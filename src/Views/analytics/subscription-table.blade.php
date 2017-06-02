<table class="table table-striped">
    <thead>
        <tr>
            <th>Plan</th>
            <th>Member</th>
            <th>Sign up Date</th>
            <th>Value</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($subscriptions as $subscription)
            @if (StoreHelper::subscriptionPlan($subscription))
                <tr>
                    <td>{!! $subscription->name !!}</td>
                    <td><a href="{{ url('admin/users/'.$subscription->user->user()->id.'/edit') }}">{{ $subscription->user->user()->name }}</a></td>
                    <td>{{ $subscription->created_at->format('d M, Y') }}</td>
                    <td>${{ StoreHelper::subscriptionPlan($subscription)->price }} / {{ StoreHelper::subscriptionPlan($subscription)->frequency }}</td>
                    <td class="text-right">
                        @if (is_null($subscription->ends_at)) {!! StoreHelper::cancelSubscriptionBtn($subscription, 'btn btn-xs btn-danger pull-right raw-margin-left-8') !!} @endif
                        <a class="btn btn-xs btn-default pull-right" href="{!! route(config('quarx.backend-route-prefix', 'quarx').'.plans.edit', [StoreHelper::subscriptionPlan($subscription)->id]) !!}"><i class="fa fa-pencil"></i> Review Plan</a>
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
