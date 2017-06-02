@extends('quarx::layouts.dashboard')

@section('content')
    <div class="row">
        <h1 class="page-header">Products</h1>
    </div>

    @include('quazar::products.breadcrumbs', ['location' => ['create']])

    {!! Form::open(['route' => config('quarx.backend-route-prefix', 'quarx').'.products.store', 'files' => true]) !!}

        {!! FormMaker::fromTable('products', config('quazar.forms.details')) !!}

        <div class="form-group text-right">
            <a href="{!! URL::previous() !!}" class="btn btn-default raw-left">Cancel</a>
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        </div>

    {!! Form::close() !!}
@endsection
