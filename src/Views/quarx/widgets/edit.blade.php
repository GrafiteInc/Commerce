@extends('quarx::quarx.layouts.dashboard')

@section('content')
    <div class="row">
        <h1 class="page-header">Widgets</h1>
    </div>

    @include('quarx::quarx.widgets.breadcrumbs', ['location' => ['edit']])

    {!! Form::model($widgets, ['route' => ['quarx.widgets.update', CryptoService::encrypt($widgets->id)], 'method' => 'patch']) !!}

        {!! FormMaker::fromObject($widgets, Quarx::config('forms.widget')) !!}

        <div class="form-group text-right">
            <a href="{!! URL::previous() !!}" class="btn btn-default raw-left">Cancel</a>
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        </div>

    {!! Form::close() !!}
@endsection
