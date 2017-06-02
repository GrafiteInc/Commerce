@extends('quarx::layouts.dashboard', ['pageTitle' => 'Subscription &raquo; Plans'])

@section('content')

    <div class="row">
        <a class="btn btn-primary pull-right" href="{!! route(config('quarx.backend-route-prefix', 'quarx').'.plans.create') !!}">Add New</a>
        <div class="pull-right">
            {!! Form::open(['url' => config('quarx.backend-route-prefix', 'quarx').'/plans/search']) !!}
             <input class="form-control header-input pull-right raw-margin-right-24" name="term" placeholder="Search">
            {!! Form::close() !!}
        </div>
        <h1 class="page-header">Subscription Plans</h1>
    </div>

    <div class="row">
        @if (isset($term))
        <div class="well text-center">Searched for "{!! $term !!}".</div>
        @endif
        @if ($plans->isEmpty())
            <div class="well text-center">No plans found.</div>
        @else
            <table class="table table-striped">
                <thead>
                    <th>Name</th>
                    <th>Enabled</th>
                    <th class="text-right" width="150px">Actions</th>
                </thead>
                <tbody>
                @foreach($plans as $plan)
                    <tr>
                        <td><a href="{!! route(config('quarx.backend-route-prefix', 'quarx').'.plans.edit', [$plan->id]) !!}">{{ $plan->name }}</a></td>
                        <td>@if ($plan->enabled) <span class="fa fa-check"></span> @endif</td>
                        <td class="text-right">
                            <a class="btn btn-default btn-xs pull-right" href="{!! route(config('quarx.backend-route-prefix', 'quarx').'.plans.edit', [$plan->id]) !!}"><i class="fa fa-pencil"></i> Edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="row">
                {!! $plans; !!}
            </div>
        @endif
    </div>

@stop
