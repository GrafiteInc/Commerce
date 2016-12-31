@extends('quarx::layouts.dashboard', ['pageTitle' => 'Subscription &raquo; Plans'])

@section('stylesheets')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ Quarx::moduleAsset('hadron', 'css/store.css', 'text/css') }}">
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1>Plans: Create</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default raw-margin-top-24">
                <div class="panel-heading text-center">
                    <h3 class="plan-title">&nbsp;</h3>
                </div>
                <div class="panel-body text-center plan-details">
                    <h2>$ <span class="plan-price"></span> <span class="plan-currency"></span>/ <span class="plan-interval"></span></h2>
                    <p><span class="plan-slogan">&nbsp;</span></p>
                    <p><span class="plan-description">&nbsp;</span></p>
                </div>
                <div class="panel-footer">
                    <span class="plan-descriptor">&nbsp;</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            {!! Form::open(['route' => 'quarx.plans.store']) !!}

            {!! FormMaker::fromTable("plans", Quarx::moduleConfig('hadron', 'plans')) !!}

            {!! Form::submit('Save', ['class' => 'btn btn-primary pull-right']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('javascript')
    @parent
    <script type="text/javascript" src="{!! Quarx::moduleAsset('hadron', 'js/store.js', 'application/javascript') !!}"></script>
@stop