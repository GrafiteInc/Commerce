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
                        <h4 class="modal-title" id="deleteModalLabel">Delete Transactions</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure want to delete this Transactions?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <a id="deleteBtn" type="button" class="btn btn-warning" href="#">Confirm Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <a class="btn btn-primary pull-right" href="{!! route('quarx.transactions.create') !!}">Add New</a>
            <div class="raw-m-hide pull-right">
                {!! Form::open(['url' => 'transactions/search']) !!}
                <input class="form-control header-input pull-right raw-margin-right-24" name="term" placeholder="Search">
                {!! Form::close() !!}
            </div>
            <h1 class="page-header">Transactions</h1>
        </div>

        <div class="row">
            @if (isset($term))
            <div class="well text-center">Searched for "{!! $term !!}".</div>
            @endif
            @if($transactions->count() === 0)
                <div class="well text-center">No Transactions found.</div>
            @else
                <table class="table table-striped">
                    <thead>
                    <th>Uuid</th>
            <th class="raw-m-hide">Provider</th>
            <th class="raw-m-hide">State</th>
            <th class="raw-m-hide">Subtotal</th>
            <th class="raw-m-hide">Tax</th>
            <th class="raw-m-hide">Total</th>
            <th class="raw-m-hide">Shipping</th>
            <th class="raw-m-hide">Refund Date</th>
            <th class="raw-m-hide">Provider Id</th>
            <th class="raw-m-hide">Provider Date</th>
            <th class="raw-m-hide">Provider Dispute</th>
            <th class="raw-m-hide">Customer Id</th>
            <th class="raw-m-hide">Notes</th>
                    <th width="50px">Action</th>
                    </thead>
                    <tbody>

                    @foreach($transactions as $transactions)
                        <tr>
                            <td>{!! $transactions->uuid !!}</td>
                    <td class="raw-m-hide">{!! $transactions->provider !!}</td>
                    <td class="raw-m-hide">{!! $transactions->state !!}</td>
                    <td class="raw-m-hide">{!! $transactions->subtotal !!}</td>
                    <td class="raw-m-hide">{!! $transactions->tax !!}</td>
                    <td class="raw-m-hide">{!! $transactions->total !!}</td>
                    <td class="raw-m-hide">{!! $transactions->shipping !!}</td>
                    <td class="raw-m-hide">{!! $transactions->refund_date !!}</td>
                    <td class="raw-m-hide">{!! $transactions->provider_id !!}</td>
                    <td class="raw-m-hide">{!! $transactions->provider_date !!}</td>
                    <td class="raw-m-hide">{!! $transactions->provider_dispute !!}</td>
                    <td class="raw-m-hide">{!! $transactions->customer_id !!}</td>
                    <td class="raw-m-hide">{!! $transactions->notes !!}</td>
                            <td>
                                <a href="{!! route('quarx.transactions.edit', [Crypto::encrypt($transactions->id)]) !!}"><i class="text-info glyphicon glyphicon-edit"></i></a>
                                <a href="#" onclick="confirmDelete('{!! route('quarx.transactions.delete', [Crypto::encrypt($transactions->id)]) !!}')"><i class="text-danger glyphicon glyphicon-remove"></i></a>
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