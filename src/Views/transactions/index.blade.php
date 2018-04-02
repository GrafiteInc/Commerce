@extends('cms::layouts.dashboard')

@section('pageTitle') Transactions @stop

@section('content')

    @include('cms::layouts.module-header', [ 'module' => 'transactions' ])

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                @if ($transactions->isEmpty())
                    @include('cms::layouts.module-search', [ 'module' => 'transactions' ])
                @else
                    <table class="table table-striped">
                        <thead>
                            <th>Transaction ID</th>
                            <th class="m-hidden">State</th>
                            <th class="m-hidden">Subtotal</th>
                            <th class="m-hidden">Tax</th>
                            <th class="m-hidden">Total</th>
                            <th class="m-hidden">Shipping</th>
                            <th class="m-hidden">Customer</th>
                            <th class="m-hidden">Refund Date</th>
                            <th class="m-hidden text-center">Refund Requested</th>
                            <th width="100px" class="text-right">Action</th>
                        </thead>
                        <tbody>

                        @foreach($transactions as $transaction)
                            <tr>
                                <td><a href="{!! route(config('cms.backend-route-prefix', 'cms').'.transactions.edit', [$transaction->id]) !!}">
                                    Transaction #{!! $transaction->id !!}</a></td>
                                <td class="m-hidden">{!! $transaction->state !!}</td>
                                <td class="m-hidden">{!! $transaction->subtotal !!}</td>
                                <td class="m-hidden">{!! $transaction->tax !!}</td>
                                <td class="m-hidden">{!! $transaction->total !!}</td>
                                <td class="m-hidden">{!! $transaction->shipping !!}</td>
                                <td class="m-hidden">{!! auth()->user()->find($transaction->user_id)->name !!}</td>
                                <td class="m-hidden">
                                    @if (!is_null($transaction->refund_date))
                                        {!! $transaction->refund_date !!}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="m-hidden text-center">
                                    @if ($transaction->refund_requested)
                                        <span class="fa fa-check"></span>
                                    @else
                                        <span class="fa fa-close"></span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a class="btn btn-sm btn-outline-primary float-right" href="{!! route(config('cms.backend-route-prefix', 'cms').'.transactions.edit', [$transaction->id]) !!}"><i class="fa fa-edit"></i> Edit</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <div class="text-center">
        {{ $pagination }}
    </div>

@endsection
