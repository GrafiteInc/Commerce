@extends('quarx::layouts.dashboard', ['pageTitle' => 'Subscription &raquo; Plans'])

@section('stylesheets')
    @parent
    {!! Minify::stylesheet(Quarx::moduleAsset('hadron', 'css/store.css', 'text/css')) !!}
@stop

@section('content')

    <div class="row">
        <h1>Plans: Edit</h1>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default raw-margin-top-24">
                <div class="panel-heading text-center">
                    <h3 class="plan-title">{{ $plan->name }}</h3>
                </div>
                <div class="panel-body text-center plan-details">
                    <h2>$ {{ $plan->amount/100 }} {{ strtoupper($plan->currency) }}/ {{ strtoupper($plan->interval) }}</h2>
                    <p><span class="plan-slogan">{{ $plan->slogan }}</span></p>
                    <p><span class="plan-description">{{ $plan->description }}</span></p>
                </div>
                <div class="panel-footer">
                    <p><span class="plan-descriptor">{{ $plan->descriptor }}</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            {!! Form::model($plan, ['route' => ['quarx.plans.update', $plan->id], 'method' => 'patch']) !!}

            {!! FormMaker::fromObject($plan, Quarx::moduleConfig('hadron', 'plans-edit')) !!}

            {!! Form::submit('Update', ['class' => 'btn btn-primary pull-right']) !!}

            {!! Form::close() !!}

            @if ($plan->enabled)
                <a href="{{ url('quarx/plans/'.$plan->id.'/state-change/disable') }}" class="btn btn-warning">Disable</a>
            @else
                <a href="{{ url('quarx/plans/'.$plan->id.'/state-change/enable') }}" class="btn btn-default">Enable</a>
            @endif
        </div>
    </div>

@stop

@section('javascript')
    @parent
    {!! Minify::javascript(Quarx::moduleAsset('hadron', 'js/store.js', 'application/javascript')) !!}
@stop
