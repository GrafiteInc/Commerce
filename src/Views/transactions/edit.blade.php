@extends('cms::layouts.dashboard')

@section('pageTitle') Transactions: Review @stop

@section('content')

    <div class="modal fade" id="refundDialog" tabindex="-3" role="dialog" aria-labelledby="refundModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="refundModalLabel">Refund Transaction</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to refund this transaction?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a id="refundBtn" class="btn btn-danger" href="#">Confirm Refund</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="row raw-margin-bottom-24">
            <div class="col-md-6 mt-2">
                @include('commerce::transactions.breadcrumbs', ['location' => ['edit']])
            </div>
            <div class="col-md-6 mt-2 text-right">
                <h4 class="raw-margin-top-8">#{{ $transaction->uuid }}</h4>
            </div>
        </div>
    </div>

    {!! Form::model($transaction, ['route' => [config('cms.backend-route-prefix', 'cms').'.transactions.update', $transaction->id], 'method' => 'patch']) !!}

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                @if ($order && $order->items->isNotEmpty())
                    <table class="table table-striped">
                        <thead>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th class="text-right">Price</th>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="text-right">${{ $item->total }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                <table class="table table-striped">
                    <tr>
                        <td><b>Subtotal</b></td>
                        <td class="text-right">${{ $transaction->subtotal }}</td>
                    </tr>
                    <tr>
                        <td><b>Tax</b></td>
                        <td class="text-right">${{ $transaction->tax }}</td>
                    </tr>
                    <tr>
                        <td><b>Shipping</b></td>
                        <td class="text-right">${{ $transaction->shipping }}</td>
                    </tr>
                    @if ($transaction->coupon)
                    <tr>
                        <td><b>Coupon</b></td>
                        <td class="text-right">${{ app(SierraTecnologia\Commerce\Models\Coupon::class)->fill(json_decode($transaction->coupon, true))->dollars }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td><b>Total</b></td>
                        <td class="text-right">${{ $transaction->total }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                @if ($order && $order->hasActiveOrderItems())
                    <div class="card bg-light border-dark">
                        <div class="card-header">
                           <a href="{{ url(config('cms.backend-route-prefix', 'cms').'/orders/'.$order->id.'/edit') }}">Order: #{{ $order->id }}</a>
                        </div>
                        <div class="card-body">
                            You must cancel this order if you wish to refund this transaction.
                        </div>
                    </div>
                @endif

                @if (!is_null($transaction->refund_date))
                    <div class="card bg-info mt-4">
                        <div class="card-header">
                           Refunded
                        </div>
                        <div class="card-body">
                            Refunded on: {{ Carbon\Carbon::parse($transaction->refund_date)->toFormattedDateString() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {!! FormMaker::fromObject($transaction, [
            'notes' => [
                'type' => 'text'
            ],
        ]) !!}

        <div class="form-group">
            {!! Form::submit('Save', ['class' => 'float-right btn btn-primary']) !!}
            {!! Form::close() !!}

            @if ($order && is_null($transaction->refund_date))
                {!! Form::open(['id' => 'refundForm', 'url' => config('cms.backend-route-prefix', 'cms').'/transactions/refund', 'method' => 'post', 'class' => 'inline-form float-left']) !!}
                    @input_maker_create('uuid', ['type' => 'hidden'], $transaction)
                    {!! Form::submit('Refund', ['class' => 'btn btn-warning']) !!}
                {!! Form::close() !!}
            @endif
        </div>
    </div>

    @if ($transaction->refunds->count() > 0)
        <div class="row raw-margin-top-24">
            <div class="col-md-12">
                <div class="well text-center">
                    <span class="lead">Refunds</span>
                </div>
                <table class="table table-striped">
                    <tr>
                        <th>Item</th>
                        <th>Amount</th>
                        <th class="text-right">Date</th>
                    </tr>
                    @foreach($transaction->refunds as $refund)
                    <tr>
                        <td>{{ $refund->orderItem->product->name }}</td>
                        <td>{{ $refund->amount }}</td>
                        <td class="text-right">{{ $refund->created_at }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    @endif
@endsection

@section('javascript')
    @parent
    <script type="text/javascript">
        $(function(){
            $('#refundForm').submit(function(e){
                e.preventDefault();
                $('#refundDialog').modal('show');
            });

            $('#refundBtn').click(function(e){
                $('#refundForm')[0].submit();
                $('#refundDialog').modal('hide');
            });
        });
    </script>
@endsection
