@extends('quarx::layouts.dashboard')

@section('content')
    <div class="col-sm-3 col-md-2 sidebar">
        <div class="raw100 raw-left raw-margin-bottom-90">
            @include('quarx::dashboard.panel')
        </div>
    </div>

    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

        <div class="row">
            <h1 class="page-header">transactions</h1>
        </div>

        @include('quarx::transactions.breadcrumbs', ['location' => ['create']])

        {!! Form::open(['route' => 'quarx.transactions.store']) !!}

            {!! FormMaker::fromTable('transactions', null, FormMaker::getTableColumns('transactions')) !!}

            <div class="form-group text-right">
                <a href="{!! URL::previous() !!}" class="btn btn-default raw-left">Cancel</a>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>
@endsection
