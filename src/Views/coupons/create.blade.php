@extends('cms::layouts.dashboard', ['pageTitle' => 'Coupons'])

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1>Coupons: Create</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            {!! Form::open(['route' => config('cms.backend-route-prefix', 'cms').'.coupons.store']) !!}

            {!! FormMaker::fromTable("coupons", config('commerce.forms.coupons')) !!}

            {!! Form::submit('Save', ['class' => 'btn btn-primary pull-right']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@stop
