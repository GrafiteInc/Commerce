@extends('cms::layouts.dashboard')

@section('content')

    <div class="modal fade" id="refundDialog" tabindex="-3" role="dialog" aria-labelledby="refundModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="refundModalLabel">Refund Transaction</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to refund this transaction?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a id="refundBtn" type="button" class="btn btn-warning" href="#">Confirm Refund</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <h1 class="page-header">Transactions: Review</h1>
    </div>

    @include('commerce::transactions.breadcrumbs', ['location' => ['edit']])

    {!! Form::model($transaction, ['route' => [config('cms.backend-route-prefix', 'cms').'.transactions.update', $transaction->id], 'method' => 'patch']) !!}

        <div class="row">
            <div class="col-md-12 raw-margin-bottom-24 text-center">
                <h2 class="text-center raw-margin-bottom-24">#{{ $transaction->uuid }}</h2>
                @if ($order && $order->hasActiveOrderItems())
                    <span class="alert alert-warning text-center">
                        You must cancel this order if you wish to refund this transaction.
                    </span>
                    <h4 class="text-center raw-margin-bottom-24 raw-margin-top-24"><a href="{{ url(config('cms.backend-route-prefix', 'cms').'/orders/'.$order->id.'/edit') }}">Order #:{{ $order->uuid }}</a></h4>
                @endif
                @if (!is_null($transaction->refund_date))
                    <div class="alert alert-success text-center">
                        <span>Refunded on: {{ Carbon\Carbon::parse($transaction->refund_date)->toFormattedDateString() }}</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            @if ($order && $order->items->isNotEmpty())
                <div class="col-md-6">
                    <table class="table table-striped">
                        <thead>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->total }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            <div class="col-md-6">
                <table class="table table-striped">
                    <tr>
                        <td><b>Subtotal</b></td>
                        <td>{{ $transaction->subtotal }}</td>
                    </tr>
                    <tr>
                        <td><b>Tax</b></td>
                        <td>{{ $transaction->tax }}</td>
                    </tr>
                    <tr>
                        <td><b>Shipping</b></td>
                        <td>{{ $transaction->shipping }}</td>
                    </tr>
                    @if ($transaction->coupon)
                    <tr>
                        <td><b>Coupon</b></td>
                        <td>{{ app(Grafite\Commerce\Models\Coupon::class)->fill(json_decode($transaction->coupon, true))->dollars }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td><b>Total</b></td>
                        <td>{{ $transaction->total }}</td>
                    </tr>
                </table>
            </div>

        </div>

        {!! FormMaker::fromObject($transaction, [
            'notes' => [
                'type' => 'text'
            ],
        ]) !!}

        <div class="form-group pull-right">
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}

    @if ($order && is_null($transaction->refund_date))
        {!! Form::open(['id' => 'refundForm', 'url' => config('cms.backend-route-prefix', 'cms').'/transactions/refund', 'method' => 'post', 'class' => 'inline-form pull-left']) !!}
            @input_maker_create('uuid', ['type' => 'hidden'], $transaction)
            {!! Form::submit('Refund', ['class' => 'btn btn-warning']) !!}
        {!! Form::close() !!}
    @endif

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
