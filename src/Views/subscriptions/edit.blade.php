@extends('quarx::layouts.dashboard')

@section('content')
    <div class="col-sm-3 col-md-2 sidebar">
        <div class="raw100 raw-left raw-margin-bottom-90">
            @include('quarx::dashboard.panel')
        </div>
    </div>

    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

        <div class="row">
            <h1 class="page-header">Subscriptions</h1>
        </div>

        @include('quarx::subscriptions.breadcrumbs', ['location' => ['edit']])

        @if ($subscriptions->hero_image)
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4">
                    <img class="thumbnail raw100" alt="" src="{{ FileUtilities::fileAsPublicAsset($subscriptions->hero_image) }}" />
                </div>
            </div>
        @endif

        {!! Form::model($subscriptions, ['route' => ['quarx.subscriptions.update', Crypto::encrypt($subscriptions->id)], 'method' => 'patch', 'files' => true]) !!}

            {!! FormMaker::fromObject(Module::config('quarx.forms.subscription'), null, $subscriptions) !!}

            <div class="form-group text-right">
                <a href="{!! URL::previous() !!}" class="btn btn-default raw-left">Cancel</a>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>
@endsection
