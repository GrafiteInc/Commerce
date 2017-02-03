@extends('quarx::layouts.dashboard')

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
        <h1 class="page-header">Transactions: Edit</h1>
    </div>

    @include('quazar::transactions.breadcrumbs', ['location' => ['edit']])

    {!! Form::model($transaction, ['route' => ['quarx.transactions.update', Crypto::encrypt($transaction->id)], 'method' => 'patch']) !!}

        <div class="row">
            <div class="col-md-12 raw-margin-bottom-24">
                <h2 class="text-center raw-margin-bottom-24">#{{ $transaction->uuid }}</h2>
                @if (!empty($order))
                    @foreach($order as $shipment)
                        <h4 class="text-center raw-margin-bottom-24"><a href="{{ url('quarx/orders/'.Crypto::encrypt($shipment->id).'/edit') }}">Order #:{{ $shipment->uuid }}</a></h4>
                    @endforeach
                @endif
                @if (!is_null($transaction->refund_date))
                    <div class="alert alert-success text-center">
                        <span>Refunded on: {{ Carbon\Carbon::parse($transaction->refund_date)->toFormattedDateString() }}</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <table class="table table-striped">
                    @foreach(json_decode($transaction->cart) as $item)
                    <tr>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->name }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-striped">
                    <tr>
                        <td>Subtotal</td>
                        <td>{{ $transaction->subtotal }}</td>
                    </tr>
                    <tr>
                        <td>Tax</td>
                        <td>{{ $transaction->tax }}</td>
                    </tr>
                    <tr>
                        <td>Shipping</td>
                        <td>{{ $transaction->shipping }}</td>
                    </tr>
                    <tr>
                        <td>{{ $transaction->total }}</td>
                        <td>Total</td>
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

    @if (is_null($transaction->refund_date) && $order->count() == 0)
        {!! Form::open(['id' => 'refundForm', 'url' => 'quarx/transactions/refund', 'method' => 'post', 'class' => 'inline-form pull-left']) !!}
            @input_maker_create('uuid', ['type' => 'hidden'], $transaction)
            {!! Form::submit('Refund', ['class' => 'btn btn-warning']) !!}
        {!! Form::close() !!}
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
