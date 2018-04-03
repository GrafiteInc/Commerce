@extends('cms::layouts.dashboard')

@section('pageTitle') Subscription Plans: Edit @stop

@section('stylesheets')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ Cms::moduleAsset('commerce', 'css/store.css', 'text/css') }}">
@stop

@section('content')

    @include('commerce::modals')

    <div class="col-md-12 mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-default raw-margin-top-24">
                    <div class="card-header text-center">
                        <h3 class="plan-title">{{ $plan->name }}</h3>
                    </div>
                    <div class="card-body text-center plan-details">
                        <h2>$ {{ $plan->amount }} {{ strtoupper($plan->currency) }}/ {{ strtoupper($plan->interval) }}</h2>
                        <p><span class="plan-description">{{ $plan->description }}</span></p>
                    </div>
                    <div class="card-footer">
                        <span class="plan-descriptor">{{ $plan->descriptor }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                {!! Form::model($plan, ['route' => [config('cms.backend-route-prefix', 'cms').'.plans.update', $plan->id], 'method' => 'patch']) !!}

                {!! FormMaker::setColumns(2)->fromObject($plan, config('commerce.forms.plans-edit')) !!}

                {!! Form::submit('Update', ['class' => 'btn btn-primary pull-right']) !!}

                {!! Form::close() !!}

                @if ($plan->enabled)
                    <a href="{{ url(config('cms.backend-route-prefix', 'cms').'/plans/'.$plan->id.'/state-change/disable') }}" class="btn btn-warning pull-right raw-margin-right-16">Disable</a>
                @else
                    <a href="{{ url(config('cms.backend-route-prefix', 'cms').'/plans/'.$plan->id.'/state-change/enable') }}" class="btn btn-outline-success pull-right raw-margin-right-16">Enable</a>
                @endif

                <form id="deletePlanForm" method="post" action="{!! url(config('cms.backend-route-prefix', 'cms').'/plans/'.$plan->id) !!}">
                    {!! csrf_field() !!}
                    {!! method_field('DELETE') !!}
                    <button class="btn delete-plan-btn btn-danger pull-left" type="submit"><i class="fa fa-trash"></i> Delete</button>
                </form>
            </div>
        </div>

        <div class="row raw-margin-top-48">
            <div class="col-md-12">
                <h4 class="raw-margin-bottom-36">Current Subscribers</h4>

                @if ($customers->count() == 0)
                    <div class="well text-center">
                        <span>You have no subscribers yet! Start selling :)</span>
                    </div>
                @else
                    <table class="table table-striped">
                        <tr>
                            <th>Customer</th>
                            <th>Active Since</th>
                            <th>Ends on</th>
                            <th class="text-right">Actions</th>
                        </tr>
                        @foreach($customers as $customer)
                            <tr>
                                <td><a href="{{ url('admin/users/'.$customer->user()->id.'/edit') }}">{{ $customer->user()->name }}</a></td>
                                <td>{{ $customer->subscription($plan->stripe_name)->created_at }}</td>
                                <td>{{ $customer->subscription($plan->stripe_name)->ends_at or 'N/A' }}</td>
                                <td>
                                    @if (is_null($customer->subscription($plan->stripe_name)->ends_at))
                                        <form class="cancel-form" method="post" action="{!! url('cms/plans/'.$plan->id.'/cancel-subscription/'.$customer->id) !!}">
                                            {!! csrf_field() !!}
                                            {!! method_field('DELETE') !!}
                                            <button class="btn btn-danger btn-xs pull-right" type="submit"><i class="fa fa-close"></i> Cancel Subscription</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>
        </div>
    </div>

@stop

@section('javascript')
    @parent
    <script type="text/javascript" src="{{ Cms::moduleAsset('commerce', 'js/plans.js', 'application/javascript') }}"></script>
    <script type="text/javascript">
        _visualizeThePlan();
    </script>
@endsection
