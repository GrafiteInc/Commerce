@extends('cms::layouts.dashboard')

@section('pageTitle') Plans: Create @stop

@section('stylesheets')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ Cms::moduleAsset('commerce', 'css/store.css', 'text/css') }}">
@stop

@section('content')

<div class="col-md-12">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default raw-margin-top-24">
                <div class="card-header text-center">
                    <h3 class="plan-title">&nbsp;</h3>
                </div>
                <div class="card-body text-center plan-details">
                    <h2>$ <span class="plan-price"></span> <span class="plan-currency"></span>/ <span class="plan-interval"></span></h2>
                    <p><span class="plan-slogan">&nbsp;</span></p>
                    <p><span class="plan-description">&nbsp;</span></p>
                </div>
                <div class="card-footer">
                    <span class="plan-descriptor">&nbsp;</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-4">
            {!! Form::open(['route' => cms()->route('plans.store')]) !!}

            {!! FormMaker::setColumns(2)->fromTable("plans", config('commerce.forms.plans')) !!}

            {!! Form::submit('Save', ['class' => 'btn btn-primary float-right']) !!}

            {!! Form::close() !!}
        </div>
    </div>
</div>

@stop

@section('javascript')
    @parent
    <script type="text/javascript" src="{!! Cms::moduleAsset('commerce', 'js/plans.js', 'application/javascript') !!}"></script>
    <script type="text/javascript">
        _visualizeThePlan();
    </script>
@stop