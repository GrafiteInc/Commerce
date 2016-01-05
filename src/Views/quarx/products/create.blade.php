@extends('quarx::quarx.layouts.dashboard')

@section('content')

        <div class="row">
            <h1 class="page-header">Products</h1>
        </div>

        @include('quarx::quarx.products.breadcrumbs', ['location' => ['create']])

        {!! Form::open(['route' => 'quarx.products.store', 'files' => true]) !!}

            {!! FormMaker::fromTable('products', Quarx::config('forms.product')) !!}

            <div class="form-group text-right">
                <a href="{!! URL::previous() !!}" class="btn btn-default raw-left">Cancel</a>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>
@endsection
