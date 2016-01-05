@extends('quarx::quarx.layouts.dashboard')

@section('content')
    <div class="row">
        <h1 class="page-header">Menus</h1>
    </div>

    @include('quarx::quarx.menus.breadcrumbs', ['location' => ['create']])

    {!! Form::open(['route' => 'quarx.menus.store']) !!}

        {!! FormMaker::fromTable('menus', FormMaker::getTableColumns('menus')) !!}

        <div class="form-group text-right">
            <a href="{!! URL::previous() !!}" class="btn btn-default raw-left">Cancel</a>
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        </div>

    {!! Form::close() !!}
@endsection
