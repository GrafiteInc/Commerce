@extends('quarx::layouts.dashboard')

@section('content')

    <div class="row">
        <div class="raw-m-hide pull-right">
            {!! Form::open(['url' => 'quarx/transactions/search']) !!}
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
                    <th class="raw-m-hide">State</th>
                    <th class="raw-m-hide">Subtotal</th>
                    <th class="raw-m-hide">Tax</th>
                    <th class="raw-m-hide">Total</th>
                    <th class="raw-m-hide">Shipping</th>
                    <th class="raw-m-hide">Customer</th>
                    <th class="raw-m-hide">Refund Date</th>
                    <th class="raw-m-hide">Refund Requested</th>
                    <th width="100px" class="text-right">Action</th>
                </thead>
                <tbody>

                @foreach($transactions as $transaction)
                    <tr>
                        <td>{!! $transaction->uuid !!}</td>
                        <td class="raw-m-hide">{!! $transaction->state !!}</td>
                        <td class="raw-m-hide">{!! $transaction->subtotal !!}</td>
                        <td class="raw-m-hide">{!! $transaction->tax !!}</td>
                        <td class="raw-m-hide">{!! $transaction->total !!}</td>
                        <td class="raw-m-hide">{!! $transaction->shipping !!}</td>
                        <td class="raw-m-hide">{!! auth()->user()->find($transaction->customer_id)->name !!}</td>
                        <td class="raw-m-hide text-center">
                            @if (!is_null($transaction->refund_date))
                                {!! $transaction->refund_date !!}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="raw-m-hide text-center">
                            @if ($transaction->refund_requested)
                                <span class="fa fa-check"></span>
                            @else
                                <span class="fa fa-close"></span>
                            @endif
                        </td>
                        <td class="text-right">
                            <a class="btn btn-xs btn-default pull-right" href="{!! route('quarx.transactions.edit', [Crypto::encrypt($transaction->id)]) !!}"><i class="fa fa-pencil"></i> Edit</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="text-center">
        {{ $pagination }}
    </div>

@endsection
