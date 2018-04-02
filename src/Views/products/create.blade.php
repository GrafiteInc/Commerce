@extends('cms::layouts.dashboard')

@section('pageTitle') Products @stop

@section('content')

    <div class="col-md-12 mt-2">
        @include('commerce::products.breadcrumbs', ['location' => ['create']])

        {!! Form::open(['route' => config('cms.backend-route-prefix', 'cms').'.products.store', 'files' => true]) !!}

            {!! FormMaker::setColumns(2)->fromTable('products', config('commerce.forms.details.identity')) !!}
            {!! FormMaker::setColumns(2)->fromTable('products', config('commerce.forms.details.price')) !!}

            {!! FormMaker::setColumns(2)->fromTable('products', config('commerce.forms.details.content')) !!}

            {!! FormMaker::setColumns(2)->fromTable('products', config('commerce.forms.details.seo')) !!}
            {!! FormMaker::setColumns(2)->fromTable('products', config('commerce.forms.details.options')) !!}

            <div class="form-group text-right">
                <a href="{!! URL::previous() !!}" class="btn btn-secondary float-left">Cancel</a>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>
        {!! Form::close() !!}
    </div>

@endsection
