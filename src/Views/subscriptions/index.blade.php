@extends('quarx::layouts.dashboard')

@section('content')

    <div class="col-sm-3 col-md-2 sidebar">
        <div class="raw100 raw-left raw-margin-bottom-90">
            @include('quarx::dashboard.panel')
        </div>
    </div>

    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

        <div class="modal fade" id="deleteModal" tabindex="-3" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="deleteModalLabel">Delete Subscriptions</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure want to delete this Subscriptions?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <a id="deleteBtn" type="button" class="btn btn-warning" href="#">Confirm Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <a class="btn btn-primary pull-right" href="{!! route('quarx.subscriptions.create') !!}">Add New</a>
            <div class="raw-m-hide pull-right">
                {!! Form::open(['url' => 'quarx/subscriptions/search']) !!}
                <input class="form-control header-input pull-right raw-margin-right-24" name="term" placeholder="Search">
                {!! Form::close() !!}
            </div>
            <h1 class="page-header">Subscriptions</h1>
        </div>

        <div class="row">
            @if (isset($term))
            <div class="well text-center">Searched for "{!! $term !!}".</div>
            @endif
            @if($subscriptions->count() === 0)
                <div class="well text-center">No Subscriptions found.</div>
            @else
                <table class="table table-striped">
                    <thead>
                    <th>Name</th>
            <th class="raw-m-hide">Cost</th>
            <th class="raw-m-hide">Provider Id</th>
            <th class="raw-m-hide">Interval</th>
            <th class="raw-m-hide">Trial</th>
            <th class="raw-m-hide">Statement Desc</th>
                    <th width="50px">Action</th>
                    </thead>
                    <tbody>

                    @foreach($subscriptions as $subscriptions)
                        <tr>
                            <td>{!! $subscriptions->name !!}</td>
                            <td class="raw-m-hide">{!! $subscriptions->cost !!}</td>
                            <td class="raw-m-hide">{!! $subscriptions->provider_id !!}</td>
                            <td class="raw-m-hide">{!! $subscriptions->interval !!}</td>
                            <td class="raw-m-hide">{!! $subscriptions->trial !!}</td>
                            <td class="raw-m-hide">{!! $subscriptions->statement_desc !!}</td>
                            <td>
                                <a href="{!! route('quarx.subscriptions.edit', [Crypto::encrypt($subscriptions->id)]) !!}"><i class="text-info glyphicon glyphicon-edit"></i></a>
                                <a href="#" onclick="confirmDelete('{!! route('quarx.subscriptions.delete', [Crypto::encrypt($subscriptions->id)]) !!}')"><i class="text-danger glyphicon glyphicon-remove"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        {!! $pagination !!}
    </div>

@endsection

<script type="text/javascript">

    function confirmDelete (url) {
        $('#deleteBtn').attr('href', url);
        $('#deleteModal').modal('toggle');
    }

</script>